<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{Classroom, Schedule, Course};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Auth, DB, Storage};
use Illuminate\Support\Facades\Validator;

class ClassroomService
{
    public static function getAllClassrooms(int $status = null): Collection
    {
        $classrooms = Classroom::query();

        if ($status !== null) {
            // dd($status);
            $classrooms = $classrooms->isActive($status);
        }

        $classrooms = $classrooms->orderBy('name', 'asc');

        return $classrooms->get();
    }

    public static function getClassrooms(Request $request): Collection
    {
        $classrooms = Classroom::query();

        if (isset($request->status)) {
            $classrooms = $classrooms->whereStatus($request->status);
        }

        if (isset($request->id)) {
            $classrooms = $classrooms->whereId($request->id);
        }

        if (isset($request->name)) {
            $classrooms = $classrooms->whereName($request->name);
        }

        return $classrooms->get();
    }

    public static function getClassroomsByTeacherId(int $teacherId, int $courseType = 0): Collection
    {
        return Classroom::whereHas('courses', function ($query) use ($teacherId, $courseType) {
            $query->where('teacher_id', $teacherId);

            if ($courseType !== 0) {
                $query->where('type', $courseType);
            }
        })->isActive()->get();
    }

    public static function getClassroomById(int $id): ?Classroom
    {
        return Classroom::whereId($id)
            ->with('courses.schedules')
            ->first();
    }

    public static function getSchedules(Classroom $classroom, $courseType = 1): Collection
    {
        return Schedule::whereStatus(1)->whereHas('course.classroom', function ($q) use ($classroom, $courseType) {
            $q->whereId($classroom->id)->whereType($courseType);
        })->with('weekday')
            ->get()
            ->unique('weekday.id')
            ->sortBy('weekday.id');

        // SELECT DISTINCT(W.SHORT_NAME) FROM SCHEDULES S
        //     INNER JOIN COURSES C ON C.ID = S.COURSE_ID
        //     INNER JOIN WEEKDAYS W ON S.WEEKDAY_ID = W.ID
        // WHERE C.CLASSROOM_ID = ?
        //    AND S.STATUS = ?
        //    AND C.TYPE = 1
        // ORDER BY W.ID ASC
    }

    public static function getWeekdays(Classroom $classroom): string
    {
        return Self::getSchedules($classroom)->implode('weekday.short_name', ', ');
    }

    public static function getStartEnd(Classroom $classroom)
    {
        $query = Course::where([['classroom_id', $classroom->id], ["type", 1]])->select('start', 'end')->get();
        $start = formatTime($query->sortBy('start')
            ->pluck('start')->first());
        $end   = formatTime($query->sortByDesc('end')
            ->pluck('end')->first());
        return "{$start} ~ {$end}";
    }

    public static function getCoursesByClassroom(Classroom $classroom, int $courseType = 1)
    {
        if ($courseType == 1) {
            // Live courses
            return $classroom->courses()->whereType($courseType)->get()->sortBy('created_at');
        } else if ($courseType == 2) {
            // Recorded Courses
            return Course::whereType($courseType)->whereHas('module', function ($q) use ($classroom) {
                $q->where('classroom_id', $classroom->id);
            })->get()->sortBy('module.created_at');
        } else {
            return null;
        }
    }

    static public function getFirstCourse(Classroom $classroom, int $courseType = 1)
    {
        if ($courseType > 2) {
            return null;
        }

        $first_module = \App\Models\Module::where('classroom_id', $classroom->id)
            ->has('courses')
            ->orderBy('created_at')
            ->first();

        return $first_module?->courses->sortByDesc('recorded_at')->first();
    }

    static public function getLastCourse(Classroom $classroom, int $courseType = 1)
    {
        if ($courseType > 2) {
            return null;
        }

        $first_module = \App\Models\Module::where('classroom_id', $classroom->id)
            ->has('courses')
            ->orderByDesc('created_at')
            ->first();

        return $first_module?->courses->sortByDesc('recorded_at')->first();
    }

    static public function getFirstModule(Classroom $classroom, int $courseType = 1)
    {
        if ($courseType > 2)
        {
            return null;
        } else
        {
            $first_module = ModuleService::getModulesByClassroom($classroom)->sortBy('created_at')->first();

            if ($first_module != null)
            {
                return $first_module;
            } else {
                return null;
            }
        }
    }

    static public function getLastModule(Classroom $classroom, int $courseType = 1)
    {
        if ($courseType > 2)
        {
            return null;
        } else
        {
            $first_module = ModuleService::getModulesByClassroom($classroom)->sortByDesc('created_at')->first();

            if ($first_module != null)
            {
                return $first_module;
            } else {
                return null;
            }
        }
    }

    public static function countByTeacherId(int $teacherId): int
    {
        return Classroom::whereHas('courses', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })
            ->isActive()
            ->count();
    }

    public static function storeClassroom(array $requestData): Classroom
    {
        $requestData['classroom']['status'] = true;
        $requestData['classroom']['school_id'] = 1;
        $requestData['classroom']['thumbnail'] = Self::uploadThumbnail($requestData['classroom']);
        return Classroom::create($requestData['classroom']);
    }

    public static function uploadThumbnail($request)
    {
        if(!isset($request['thumbnail'])){
            return 'thumbnails/default_thumbnail.png';
        };

        if ($request['thumbnail']) {
            $fileName = uniqid(date('HisYmd')) . ".{$request['thumbnail']->extension()}";

            Storage::putFileAs(
                'public/thumbnails', $request['thumbnail'], $fileName
            );

            return 'thumbnails/' . $fileName;
        } else {
            return 'thumbnails/default_thumbnail.png';
        }
    }
    public static function updateClassroom(array $requestData, Classroom $classroom): void
    {
        if(isset($requestData['thumbnail'])){
            deleteFile($classroom->getRawOriginal('thumbnail'));
            $requestData['thumbnail'] = Self::uploadThumbnail($requestData);
        };

        $classroom->update($requestData);
    }

    public static function deleteClassroom(Classroom $classroom): void
    {
        deleteFile($classroom->getRawOriginal('thumbnail'));
        $classroom->delete();
    }

    public static function forceDeleteClassroom(Classroom $classroom): void
    {
        $classroom->forceDelete();
    }

    public static function restoreClassroom(Classroom $classroom): void
    {
        $classroom->restore();
    }

    /* Chat */
    public static function addStudent(Classroom $classroom, int $IdStudent): void
    {
        $classroom->students()->attach($IdStudent);
    }

    public static function removeStudent(Classroom $classroom, int $IdStudent): void
    {
        $classroom->students()->detach($IdStudent);
    }
    
    /* Validation */
    public static function validateEditCourses(array $edit): array
    {
        $errors = [];
        
        if (is_array($edit['schedules'] ?? [])) {
            foreach ($edit['schedules'] as $key => $schedule) {
                $course = $edit['course'][$key] ?? [];
                
                $validator = Validator::make([
                    'name' => $course['name'] ?? null,
                    'link' => $course['link'] ?? null,
                    'teacher_id' => $course['teacher_id'] ?? null,
                    'start' => $course['start'] ?? null,
                    'end' => $course['end'] ?? null,
                ], [
                    'name' => ['required', 'string'],
                    'link' => ['nullable', 'url'],
                    'teacher_id' => ['required', 'integer', 'exists:users,id'],
                    'start' => ['required'],
                    'end' => ['required', 'after:start'],
                ], [
                    'required' => 'O campo :attribute é obrigatório.',
                    'name.required' => 'O campo Nome da aula é obrigatório.',
                    'link.url' => 'O Link informado é inválido.',
                    'teacher_id.required' => 'O campo Professor é obrigatório.',
                    'end.required' => 'A hora de fim é obrigatório.',
                    'end.after' => 'A hora de fim deve ser maior do que a de início.',
                ]);

                if ($validator->fails()) {                    
                    foreach ($validator->errors()->messages() as $field => $messages) {
                        $errors["edit.course.$key.$field"] = $messages;
                    }
                }
            }
        }

        return $errors;
    }
    public static function validatedCreateCourses(array $create): array
    {
        $errors = [];
        $schedules = $create['schedules'] ?? [];
        $courses = $create['course'] ?? [];
        
        if (is_array($schedules)) {
            foreach ($schedules as $key => $schedule) {
                $course = $courses[$key] ?? [];
                
                $validator = Validator::make([
                    'name' => $course['name'] ?? null,
                    'link' => $course['link'] ?? null,
                    'teacher_id' => $course['teacher_id'] ?? null,
                    'start' => $course['start'] ?? null,
                    'end' => $course['end'] ?? null,
                ], [
                    'name' => ['required', 'string'],
                    'link' => ['nullable', 'url'],
                    'teacher_id' => ['required', 'integer', 'exists:users,id'],
                    'start' => ['required'],
                    'end' => ['required', 'after:start'],
                ], [
                    'required' => 'O campo :attribute é obrigatório.',
                    'name.required' => 'O campo Nome da aula é obrigatório.',
                    'link.url' => 'O Link informado é inválido.',
                    'teacher_id.required' => 'O campo Professor é obrigatório.',
                    'end.required' => 'A hora de fim é obrigatório.',
                    'end.after' => 'A hora de fim deve ser maior do que a de início.',
                ]);

                if ($validator->fails()) {                    
                    foreach ($validator->errors()->messages() as $field => $messages) {
                        $errors["create.course.$key.$field"] = $messages;
                    }
                }
            }
        }

        return $errors;
    }

    public static function validateEditClassroom(array $classroom): array
    {
        $errors = [];
        
        if (is_array($classroom ?? [])) {
            $validator = Validator::make([
                'name' => $classroom['name'] ?? null,
                'description' => $classroom['description'] ?? null,
                'evaluation_model_id' => $classroom['evaluation_model_id'] ?? null,
                'thumbnail' => $classroom['thumbnail'] ?? null
            ], [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['nullable','max:950'],
                'evaluation_model_id' => ['nullable', 'exists:evaluation_models,id'],
                'thumbnail' => ['nullable', 'mimes:jpg,jpeg,png', 'max:650'],
            ], [
                'name.required' => 'O campo Nome da turma é obrigatório.',
                'name.string' => 'O campo Nome da turma deve conter apenas letras.',
                'name.max' => 'O campo Nome da turma deve possuir no máximo 255 caracteres.',
                'description.max' => 'O campo Descrição da turma deve possuir no máximo 950 caracteres.',
                'evaluation_model_id.exists' => 'O campo Modelo de avaliação não existe',
                'thumbnail.required' => 'O campo Thumbnail é obrigatório',
                'thumbnail.max' => 'O campo Thumbnail deve possuír até 650 KBs',
                'thumbnail.mimes' => 'O campo Thumbnail deve ser um JPG, JPEG ou PNG',
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $field => $messages) {
                    $errors["classroom.$field"] = $messages;
                }
            }
        }

        return $errors;
    }
}

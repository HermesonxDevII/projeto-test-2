<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{Course, Schedule, Classroom, Student};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseService
{
    static public function getAllCourses(array $types = null): Collection
    {
        $courses = Course::query();

        if ($types != null)
        {
            $courses = $courses->hasTypes($types);
        }

        return $courses->get();
    }

    static public function getCourses(Request $request): Collection
    {
        $courses = Course::with('schedules.classroom');

        if ($request->filled('id')) {
            $courses = $courses->whereId($request->id);
        }

        if ($request->filled('type')) {
            $courses = $courses->wheretype($request->type);
        }

        if ($request->filled('class_name')) {
            $courses = $courses->where('class_name', $request->class_name);
        }

        return $courses->get();
    }

    static public function getCourseById(int $id): Course
    {
        return Course::findOrFail($id);
    }

    static public function getSchedules(Course $course): Collection
    {
        return Schedule::whereStatus(1)->whereHas('course', function ($q) use ($course) {
            $q->whereId($course->id);
        })->with('weekday')
            ->get()
            ->unique('weekday.id')
            ->sortBy('weekday.id');
    }

    static public function getBasicData(Course $course): Array
    {
        $classroom = $course->type == 1
            ? $course->classroom
            : $course->module->classroom;

        $course_is_done = null;

        if (Auth::user()->is_guardian)
        {
            $course_is_done = StudentService::getStudentById(session()->get('student_id'))->courseIsDone($course);
        }

        if($course->recorded_at != null){
            $data = $course->getOriginal('recorded_at');
            $data = explode(' ', $data);
            $data = explode('-', $data[0]);
            $data = $data[0]."/".$data[1]."/".$data[2];
        } else {
            $data = null;
        }

        return [
            'id' => $course->id,
            'name' => $course->name,
            'embed_code' => $course->embed_code,
            'link' => $course->embedurl,
            'description' => $course->description_formatted,
            'is_done' => $course_is_done,
            'recorded_at_formatted' => $data,
            'classroom' => [
                'id' => $classroom->id,
                'name' => $classroom->formatted_name
            ],
            'teacher' => [
                'id' => $course->teacher?->id ?? 0,
                'name' => $course->teacher?->formatted_name ?? 'Não encontrado'
            ],
            'materials' => $course->materials
        ];
    }

    static public function getWeekdays(Course $course): String
    {
        return Self::getSchedules($course)->implode('weekday.short_name', ', ');
    }

    static public function getWeekdaysTranslated(Course $course): String
    {
        $weekdays = [];

        foreach (Self::getSchedules($course) as $schedule) {
            array_push($weekdays, __("classroom.weekdays.{$schedule->weekday_id}"));
        }
        
        return Arr::join($weekdays, '-');
    }

    static public function getPercentageByStudent(Course $course, Student $student, int $status = 1): string
    {
        $finished_courses = Course::whereId($course->id)->whereHas('students', function ($q) use ($student, $status) {
            $q->where('student_id', $student->id)->where('student_course.status', $status);
        })->get()->count();

        $total_courses = Course::whereHas('module', function ($q) use ($student) {
            $q->whereIn('classroom_id', $student->classrooms->pluck('id'));
        })->get()->count();

        return intval(($finished_courses / max($total_courses, 1)) * 100);
    }

    static public function countByTeacherId(int $teacherId): int
    {
        return Course::where('teacher_id', $teacherId)->count();
    }

    static public function storeCourse($course_data): Course
    {
        return Course::create($course_data);
    }

    static public function updateCourse(Course $course, array $courseData): void
    {
        $course->update($courseData);
    }

    static public function deleteCourse(int $course_id): void
    {
        $course = Course::find($course_id);
        $course->materials()->delete();
        $course->delete();
    }
}

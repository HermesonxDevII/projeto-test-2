<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\{Classroom, Course, Material, Module, Student};
use App\Services\{ClassroomService, CourseService, FileService, ModuleService, ScheduleService, StudentService, UserService};
use Illuminate\Contracts\View\View;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\{Auth, DB};

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Classroom $classroom): View
    {
        $this->authorize('view', $classroom);
        $user = loggedUser();
        $student = selectedStudent();
        $statistics = [];

        if ($user->is_guardian) {
            $finished_courses = StudentService::getCourses($student, 2, null, $classroom->id)->count();
            $total_courses = ClassroomService::getCoursesByClassroom($classroom, 2)->count();

            $statistics = [
                'finished' => $finished_courses,
                'total' => $total_courses,
                'percentage' => ($finished_courses == 0 || $total_courses == 0)
                    ? 0
                    : ($finished_courses / $total_courses) * 100
            ];
        }

        $modulesWithCourses = [];
        $modules = $classroom->modules()->orderByDesc('created_at')->get();

        foreach($modules as $module){
            if($module->courses->count() > 0) {
                $modulesWithCourses[] = $module;
            }
        }

        $first_module = ClassroomService::getLastModule($classroom);
        $first_course = ClassroomService::getLastCourse($classroom, 2);
        return view('courses.recorded.index', compact('classroom', 'student', 'first_course', 'first_module', 'statistics', 'modulesWithCourses'));
    }

    public function create(Classroom $classroom): View
    {
        $this->authorize('create', Course::class);

        $data = [
            'modules'   => ModuleService::getModulesByClassroom($classroom),
            'teachers'  => UserService::getTeachers(),
            'classroom' => $classroom
        ];

        return view('courses.recorded.create', compact('data'));
    }

    public function store(CourseRequest $request): RedirectResponse
    {
        $this->authorize('create', Course::class);

        DB::beginTransaction();
        try {
            $course = CourseService::storeCourse($request->input('course'));

            if ($course->type == 1) {
                ScheduleService::storeSchedules(
                    $request->input("schedules"),
                    $course->id
                );
            }

            if ($request->hasFile('materials')) {
                foreach ($request->file('materials') as $key => $file) {
                    FileService::storeMaterial($course, $file);
                }
            }

            DB::commit();
            notify('Aula cadastrada com sucesso!');
            return redirect()->route('classrooms.recorded-courses', $request->input('course.classroom_id'));
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível cadastrar a aula solicitada.', 'error');
            return back();
        }
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);
        return dd($course);
    }

    public function edit(Classroom $classroom, Course $course): View
    {
        $this->authorize('update', $course);

        if ($classroom->id == null) {
            $classroom = $course->classroom;
        }

        $data = [
            'course'    => $course,
            'module'    => $course->module,
            'modules'   => ModuleService::getModulesByClassroom($classroom),
            'teachers'  => UserService::getTeachers(),
            'classroom' => $classroom,
            'materials' => $course->materials
        ];

        return view('courses.recorded.edit', compact('data'));
    }

    public function update(CourseRequest $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        DB::beginTransaction();
        try {
            CourseService::updateCourse($course, $request->input('course'));

            if ($request->filled('deleted_files')) {
                foreach (explode(',', $request->input('deleted_files')) as $file_id) {
                    FileService::deleteMaterial($file_id);
                }
            }

            if ($request->hasFile('materials')) {
                foreach ($request->file('materials') as $key => $file) {
                    FileService::storeMaterial($course, $file);
                }
            }

            DB::commit();
            notify('Aula atualizada com sucesso!');
            return redirect()->route('classrooms.recorded-courses', $request->input('course.classroom_id'));
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar a aula solcitada.', 'error');
            return back();
        }
    }

    public function destroy(Course $course): JsonResponse
    {
        $this->authorize('delete', $course);

        DB::beginTransaction();
        try {
            CourseService::deleteCourse($course->id);

            DB::commit();

            notify('Aula excluída com sucesso!');
            return response()->json([
                'icon' => 'success',
                'msg'  => 'Aula excluída com sucesso!'
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível excluir a aula solicitada.', 'error');
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível excluir a aula solicitada.'
            ]);
            return back();
        }
    }

    public function getBasicData(Course $course): array
    {
        return CourseService::getBasicData($course);
    }
}

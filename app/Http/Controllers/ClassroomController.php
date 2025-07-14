<?php

namespace App\Http\Controllers;

use App\Enums\ConversationType;
use App\Enums\ParticipantRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Jobs\NotifyStartCourseToUsers;
use App\Events\CourseStartNotification;
use App\Http\Requests\ClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use App\Models\{Classroom, Conversation, Course, Evaluation, EvaluationModel, Student, User, Weekday};
use App\Services\{ChatService, ClassroomService, UserService, CourseService, ScheduleService, StudentService};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ClassroomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $this->authorize('view', Classroom::class);
        $user = loggedUser();
        $student_id = session()->get('student_id');
        $student = null;
        $classrooms = null;

        if ($user->is_administrator) {
            $classrooms = ClassroomService::getAllClassrooms();

            return view('classrooms.index', compact('classrooms', 'student'));
        }

        if ($user->is_teacher) {
            $classrooms = ClassroomService::getClassroomsByTeacherId($user->id, 1);

            return view('classrooms.index', compact('classrooms', 'student'));
        }

        if ($student_id == null && $user->studentsCount >= 1) {
            return redirect()->route('students.chooseStudent');
        }

        $student = StudentService::getStudentById($student_id);
        $classrooms = $student->classrooms;

        // CourseStartNotification::dispatch($classrooms->first()->courses->first());

        return view('classrooms.index', compact('classrooms', 'student'));
    }

    public function create(): View
    {
        $classroom_id = session('classroom_id');
        $courses = null;

        if ($classroom_id) {

            $classroom = Classroom::with('courses')->find($classroom_id);
            $courses = $classroom?->courses;
            return view('classrooms.create', compact('courses'));
        }        

        $this->authorize('create', Classroom::class);
        $teachers = UserService::getTeachers();
        $weekdays = Weekday::all();
        $evaluationModels = EvaluationModel::all();

        return view('classrooms.create', compact('teachers', 'weekdays', 'evaluationModels'));
    }

    public function store(ClassroomRequest $request): RedirectResponse
    {
        $requestData = $request->validated();

        $this->authorize('create', Classroom::class);
        DB::beginTransaction();        
        try {

            $courses = [];
            $classroom = ClassroomService::storeClassroom($requestData);
            if ($request->filled('course')) {
                foreach ($request->input('course') as $key => $courseData) {
                    $course = CourseService::storeCourse(
                        array_merge($courseData, ['classroom_id' => $classroom->id])
                    );

                    ScheduleService::storeSchedules(
                        $request->input("schedules.{$key}"),
                        $course->id
                    );

                    array_push($courses, $course);
                    // CourseStartNotification::dispatch($course);
                    // NotifyStartCourseToUsers::dispatch$)->delay(now()->addMinutes(1));
                }
            }

            // Criar o grupo de chat
            ChatService::createGroup($classroom, $courses);
            

            DB::commit();
            notify('Turma cadastrada com sucesso!');

            return redirect()->route('classrooms.create')->with('success', true)->with('classroom_id', $classroom->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível cadastrar a turma solicitada.', 'error');
            return back();
        }
    }

    public function show(Classroom $classroom): View
    {
        $this->authorize('view', $classroom);
        $students = StudentService::getStudentsByClassroom($classroom);

        $oneMonthAgo = Carbon::now()->subMonth();

        $studentsRelationship = $classroom->students()->withPivot('created_at')->get();
        
        $classroom->students = $studentsRelationship->sortByDesc(function ($student) use ($oneMonthAgo) {
            return $student->pivot->created_at >= $oneMonthAgo ? 1 : 0;            
        })->sortByDesc(function ($student) {
            return $student->pivot->created_at ?? now();
        });

        $classroom->evaluations = $classroom->evaluations->sortByDesc('date');

        return view('classrooms.show', compact('classroom', 'students'));
    }

    public function edit($id): View
    {
        $classroom = ClassroomService::getClassroomById($id);
        $teachers = UserService::getTeachers();
        $weekdays = Weekday::all();
        $evaluationModels = EvaluationModel::all();

        return view('classrooms.edit', compact('teachers', 'weekdays', 'classroom', 'evaluationModels'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $edit = $request->input('edit');
        $create = $request->input('create');
        $data_classroom = $request->input('classroom');
        $errors = [];

        $errors_classroom = $data_classroom ? ClassroomService::validateEditClassroom($data_classroom) : [];
        $errors_update_courses = $edit ? ClassroomService::validateEditCourses($edit) : [];
        $errors_create_courses = $create ? ClassroomService::validatedCreateCourses($create): [];

        $errors = array_merge($errors_classroom, $errors_update_courses, $errors_create_courses);
        
        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors($errors);
                
        }

        $this->authorize('update', $classroom);
        DB::beginTransaction();
        try {

            try {

                ClassroomService::updateClassroom(
                    $request['classroom'],
                    $classroom
                );

            } catch (\Exception $ex) {

                throw new \Exception("Erro ao atualizar a turma: " . $ex->getMessage(), 0, $ex);
            }


            // Edit
            if ($request->filled('edit')) {
                foreach ($request->input('edit')['course'] as $key => $courseData) {

                    $oldCourseData = CourseService::getCourseById($key);
                    $newCourseData = $courseData;
                    // se o curso mudar de professor, retiro o professor antigo do grupo e adiciono o novo
                    if ($oldCourseData->teacher_id !== $newCourseData['teacher_id']) {
                        ChatService::removeParticipant($classroom, $oldCourseData->teacher_id, 'teacher');
                    }

                    CourseService::updateCourse(
                        CourseService::getCourseById($key),
                        $courseData
                    );

                    ChatService::addTeacher($classroom, $courseData['teacher_id']);

                    foreach ($request->input('edit')["schedules"]["{$key}"] as $key => $scheduleData) {
                        ScheduleService::updateSchedule(
                            ScheduleService::getScheduleById($key),
                            $scheduleData['status']
                        );
                    }
                }
            }

            // Create
            if ($request->filled('create')) {
                foreach ($request->input('create')['course'] as $key => $courseData) {

                    $course = CourseService::storeCourse(
                        array_merge($courseData, ['classroom_id' => $classroom->id])
                    );

                    ScheduleService::storeSchedules(
                        $request->input('create')["schedules"]["{$key}"],
                        $course->id
                    );

                    ChatService::addTeacher($classroom, $courseData['teacher_id']);
                }
            }

            // Delete
            $courses_id = explode(',', $request->input('deleted_courses'));
            if (strlen($request->input('deleted_courses'))) {
                foreach ($courses_id as $key => $course_id) {
                    $course = Course::find($course_id);
                    
                    ChatService::removeParticipant($classroom, $course->teacher_id, 'teacher');

                    CourseService::deleteCourse($course_id);
                }
            }

            DB::commit();
            notify('Turma atualizada com sucesso!');
        } catch (\Throwable $ex) {
            DB::rollBack();
            
            notify('Não foi possível cadastrar a turma solicitada.', 'error');

            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar a turma.']);
        }
        return redirect()->route('classrooms.index');
    }

    public function destroy(Classroom $classroom): JsonResponse
    {
        DB::beginTransaction();
        try {
            ClassroomService::deleteClassroom($classroom);

            DB::commit();

            return response()->json([
                'icon' => 'success',
                'msg'  => 'Turma excluída com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível excluir a turma solicitada.'
            ], 500);
        }
    }

    public function restore(Classroom $classroom): void
    {
        ClassroomService::restoreClassroom($classroom);
    }

    public function getBasicData(Request $request): array
    {
        $classroom = ClassroomService::getClassroomById($request->input('id'));

        return [
            'id' => $classroom->id,
            'name' => $classroom->formatted_name,
            'created_at' => $classroom->created_at,
            'students' => $classroom->students->count(),
            'weekdays' => $classroom->weekDays
        ];
    }

    public function addStudent(Request $request): JsonResponse
    {
        $this->authorize('addStudent', Classroom::class);
        DB::beginTransaction();
        try {
            ClassroomService::addStudent(
                ClassroomService::getClassroomById($request->input('classroomId')),
                $request->input('studentId')
            );

            $student = StudentService::getStudentById(
                $request->input('studentId')
            );

            ChatService::addStudent(ClassroomService::getClassroomById($request->input('classroomId')), $request->input('studentId') );

            DB::commit();

            $data = [
                'student_id' => $student->id,
                'student_start_date' => $student->created_at,
                'student_name' => $student->full_name,
                'guardian_name' => $student->guardian->name,
                'student_status' => $student->status,
            ];

            return response()->json([
                'icon' => 'success',
                'msg'  => 'Aluno adicionado com sucesso!',
                'data' => $data
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível adicionar o aluno solicitado.'
            ], 500);
        }
    }

    public function removeStudent(Request $request): JsonResponse
    {
        $this->authorize('removeStudent', Classroom::class);
        DB::beginTransaction();
        try {
            ClassroomService::removeStudent(
                ClassroomService::getClassroomById($request->input('classroomId')),
                $request->input('studentId')
            );

            ChatService::removeParticipant(ClassroomService::getClassroomById($request->input('classroomId')), $request->input('studentId'), "student");

            DB::commit();
            return response()->json([
                'icon' => 'success',
                'msg'  => 'Aluno removido com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível remover o aluno solicitado.'
            ], 500);
        }
    }

    public function recordedCourses(Classroom $classroom): View
    {
        return view('courses.recorded.index', compact('classroom'));
    }

    public function getClassroomWithEvaluationsByPeriod(Request $request)
    {
        $studentId = $request->get('student_id');
        $period = $request->get('period');

        [$startDate, $endDate] = explode(' - ', $period);
        $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', trim($endDate))->format('Y-m-d');

        $classrooms = Classroom::whereHas('evaluations', function ($query) use ($startDate, $endDate, $studentId) {
            $query->whereBetween('date', [$startDate, $endDate])
                    ->whereHas('studentEvaluations', function ($subQuery) use ($studentId) {
                        $subQuery->where('student_id', $studentId);  
                    });
        })->select('id', 'name')->get();

        return response()->json($classrooms);
    }
}

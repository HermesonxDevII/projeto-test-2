<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use App\Models\StudentEvaluation;
use Illuminate\Http\JsonResponse;
use App\Exports\EvaluationsExport;
use Illuminate\Support\Facades\{ DB, Mail, Storage, Log };
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\{ StudentRequest };
use App\Models\{ AcessLog, Student, User, School, Address, Classroom, Language, Course, Grade, VideoCourse, VideoCourseClass, VideoCourseModule };
use App\Services\{ChatService, ClassroomService, CourseNotificationService, CourseService, GuardianService, StudentService, UserService, VideoCourseService};
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Student::class);

        $user = loggedUser();

        $query = Student::query();

        if ($user->is_administrator) {
            $students = StudentService::getAllStudents();
            $classrooms = ClassroomService::getAllClassrooms();
            $grades = Grade::all();
        } else {
            $students = StudentService::getStudentsByTeacherId($user->id);
            $classrooms = [];
            $grades = [];
        }

        if ($request->filled('grade_id')) {
            $query->where('grade_id', $request->grade_id);
        }

        if ($request->filled('classroom_id')) {
            $query->whereHas('classrooms', function ($q) use ($request) {
                $q->where('classroom_id', $request->classroom_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('period')) {
            [$start, $end] = explode(' - ', $request->period);
            $query->whereBetween('created_at', [Carbon::createFromFormat('d/m/Y', $start), Carbon::createFromFormat('d/m/Y', $end)]);
        }

        $students = $query
            ->with(['lastAccessLog' => function (HasOne $q) {
                $q->latest('accessed_at');
            }])
            ->get();
        
        $courses = VideoCourse::all();
        
        return view('students.index', compact('students', 'classrooms', 'grades', 'courses'));
    }

    public function create(): View
    {
        $this->authorize('create', Student::class);

        $data = [
            'grades' => Grade::all()->sortBy("name"),
            'languages' => Language::all(),
            'classrooms' => ClassroomService::getAllClassrooms()
        ];

        return view('students.create', compact('data'));
    }

    public function store(StudentRequest $request): RedirectResponse
    {
        $this->authorize('create', Student::class);
        DB::beginTransaction();
        try {
            $guardianData = $request->validated()['guardian'];

            if(isset($guardianData['email'])){
                $guardian = User::withTrashed()->where('email', $guardianData['email'])->first();
            } else {
                $guardian = User::withTrashed()->find($guardianData['id']);
            }

            if ($guardian) {
                if ($guardian->trashed()) {
                    $guardian->restore();
                }
                $guardianId = $guardian->id;
            } else {
                // Criar um novo responsável
                $guardianId  = GuardianService::storeGuardian($guardianData);
            }

            $studentData = $request->input('student');
            $studentData['guardian_id'] = $guardianId;

            $studentId = StudentService::storeStudent($studentData);
            
            if (array_key_exists('classrooms', $studentData)) {
                foreach ($studentData['classrooms'] as $classroom_id) {
                    ChatService::addStudent(ClassroomService::getClassroomById($classroom_id), $studentId);
                }
            }
            

            DB::commit();

            if ($request['student']['send_email'] == '1') {
                Mail::to($guardian->email)->send(new WelcomeMail($guardianId, $studentData['full_name']));
            }
            notify('Aluno cadastrado com sucesso!');
        } catch (\Exception $ex) {
            DB::rollback();
            notify('Não foi possível cadastrar o aluno solicitado.', 'error');
        }
        return redirect()->route('students.index');
    }


    public function show(Student $student): View
    {
        $this->authorize('view', Student::class);

        $guardian = $student->guardian;
        $address = $guardian && $guardian->address ? $guardian->address->first() : '';

        $data = [
            'student'    => $student,
            'guardian'   => $guardian,
            'address'    => $address,
            'classrooms' => $student->classrooms
        ];

        return view('students.show', compact('data'));
    }

    public function edit(Student $student): View
    {
        $this->authorize('update', $student);

        $data = [
            "student" => $student,
            "student_classrooms" => $student->classrooms,
            "all_classrooms" => ClassroomService::getAllClassrooms(),
            "grades" => Grade::all()->sortBy("name"),
            "languages" => Language::all()
        ];

        return view('students.edit', compact('data'));
    }

    public function update(StudentRequest $request, Student $student): RedirectResponse
    {
        $this->authorize('update', $student);
        $user = loggedUser();

        DB::beginTransaction();
        try {
            StudentService::updateStudent(
                $request,
                $student
            );

            DB::commit();
            if (isset($request['student']['send_email'])) {
                if ($request['student']['send_email'] == '1') {
                    Mail::to($student->guardian->email)->send(new WelcomeMail($student->guardian->id, $request['student']['full_name']));
                }
            }
            notify('Aluno atualizado com sucesso!');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar o aluno solicitado.', 'error');
        }

        if ($user->is_administrator) {
            return redirect()->route('students.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function destroy(Student $student): JsonResponse
    {
        $this->authorize('delete', Student::class);
        DB::beginTransaction();
        try {
            StudentService::deleteStudent($student);

            DB::commit();

            return response()->json([
                'icon' => 'success',
                'msg'  => 'Aluno excluído com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível excluir o aluno solicitado.'
            ], 500);
        }
    }

    public function restore(Student $student): void
    {
        $this->authorize('restore', Student::class);
        StudentService::restoreStudent($student);
    }

    public function choose_student(): View
    {
        $students = loggedUser()->students->where('status', '1');
        return view('students.choose_student', compact('students'));
    }

    public function select_student(Request $request): void
    {
        $user = loggedUser();
        
        if ($request->filled('student_id')) {
            $student = StudentService::getStudentById($request->input('student_id'));

            $request->session()->put('student_id', $student->id);
            $request->session()->put('student_name', $student->firstName);
            $request->session()->put('student_nickname', $student->nickname);
            $request->session()->put('student_avatar_id', $student->avatar_id);

            AcessLog::create([
                'user_id' => $user->id,
                'student_id' => $student->id,
                'role' => 'guardian',
                'accessed_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } else {
            $student = $user->students->first();

            $request->session()->put('student_id', $student->id);

            AcessLog::create([
                'user_id' => $user->id,
                'student_id' => $student->id,
                'role' => 'guardian',
                'accessed_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }
    }

    public function mark_course_as_done(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $course = CourseService::getCourseById($request->input('course_id'));
            $classroom = ClassroomService::getClassroomById($request->input('classroom_id'));

            $course->students()->attach($course->id, [
                "student_id" => $request->input('student_id'),
                "course_id"  => $course->id,
                "status"     => 1
            ]);

            DB::commit();
            return response()->json([
                'icon' => 'success',
                'msg'  => __('notifications.lesson_completed'),
                'data' => StudentService::getClassroomStatistics($classroom)
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível atualizar o status da aula.'
            ], 500);
        }
    }

    public function unmark_course_as_done(Request $request)
    {
        DB::beginTransaction();
        try {
            $classroom = ClassroomService::getClassroomById($request->input('classroom_id'));

            CourseService::getCourseById($request->input('course_id'))
                ->students()->detach($request->input('student_id'));

            DB::commit();
            return response()->json([
                'icon' => 'success',
                'msg'  => __('notifications.lesson_not_completed'),
                'data' => StudentService::getClassroomStatistics($classroom)
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível atualizar o status da aula.'
            ], 500);
        }
    }

    public function video_course_class_view(Student $student, VideoCourseClass $class)
    {
        DB::beginTransaction();
        try {
            $videoCourseClassViewQuery = $student->videoCourseClassViews()->where('video_course_class_id', $class->id);

            if ($videoCourseClassViewQuery->exists()) {
                $student->videoCourseClassViews()->detach($class->id);
            } else {
                $student->videoCourseClassViews()->attach($class->id, ['viewed_at' => now()->format('Y-m-d H:i:s')]);
            }

            $videoCourse = $class->module->videoCourse;           

            DB::commit();
            return response()->json([
                'icon' => 'success',
                'student_name' => $student->full_name,
                'progress_course' => VideoCourseService::getVideoCourseProgressByStudentId($videoCourse, $student->id),
                'msg'  => $videoCourseClassViewQuery->exists()
                    ? __('notifications.lesson_completed')
                    : __('notifications.lesson_not_completed'),
                'data' => StudentService::getVideoCourseClassStatistics($class)
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível atualizar o status da aula.'
            ], 500);
        }
    }

    public function getCoursesOfSelectedStudent(int $courseType = 1)
    {
        return StudentService::getCoursesOfSelectedStudent($courseType);
    }

    public function getWeeklyNotificationsByStudentSelected(int $courseType = 1)
    {
        return CourseNotificationService::getWeeklyNotificationsByStudentSelected($courseType);
    }

    public function update_classroom_onboarding_preference(Student $student, Request $request)
    {
        $student->update([
            'classroom_onboarding_preference' => $request['preference']
        ]);
    }

    public function update_course_onboarding_preference(Student $student, Request $request)
    {
        $student->update([
            'course_onboarding_preference' => $request['preference']
        ]);
    }

    public function export(Request $request)
    {
        return Excel::download(new StudentsExport($request), 'students.xlsx');
    }

    public function getUnrelatedClassrooms(Request $request)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        $studentIds = $request->input('students');

        $classrooms = Classroom::whereDoesntHave('students', function ($query) use ($studentIds) {
            $query->whereIn('students.id', $studentIds);
        })->select('id', 'name')->get();

        return response()->json([
            'success' => true,
            'classrooms' => $classrooms,
        ]);
    }

    public function getRelatedClassrooms(Request $request)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        $studentIds = $request->input('students');

        $classrooms = Classroom::whereHas('students', function ($query) use ($studentIds) {
            $query->whereIn('students.id', $studentIds);
        })->select('id', 'name')->get();

        return response()->json([
            'success' => true,
            'classrooms' => $classrooms,
        ]);
    }

    public function changeClassrooms(Request $request)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $studentIds = $request->input('students');
        $classroomId = $request->input('classroom_id');

        foreach ($studentIds as $studentId) {
            $student = Student::find($studentId);

            if (!$student->classrooms()->where('classroom_id', $classroomId)->exists()) {
                $student->classrooms()->attach($classroomId);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Estudantes adicionados à sala de aula com sucesso',
        ]);
    }

    public function changeSeries(Request $request)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'grade_id' => 'required|exists:grades,id',
        ]);

        $studentIds = $request->input('students');
        $gradeId = $request->input('grade_id');

        foreach ($studentIds as $studentId) {
            $student = Student::find($studentId);
            
            if ($student->grade_id != $gradeId) {
                $student->grade_id = $gradeId;
                $student->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Estudantes adicionados à nova série com sucesso',
        ]);
    }

    public function includeVideoCourses(Request $request)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'video_courses' => 'required|array',
            'video_courses.*' => 'exists:video_courses,id',
        ]);

        $studentIds = $request->input('students');
        $videoCourseIds = $request->input('video_courses');

        foreach ($studentIds as $studentId) {
            $student = Student::find($studentId);

            $student->videoCourses()->syncWithoutDetaching($videoCourseIds);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cursos de vídeo associados aos estudantes com sucesso',
        ]);
    }

    public function removalClassrooms(Request $request)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'classrooms' => 'required|array',
            'classrooms.*' => 'exists:classrooms,id',
        ]);

        $studentIds = $request->input('students');
        $classroomsIds = $request->input('classrooms');

        foreach ($studentIds as $studentId) {
            $student = Student::find($studentId);

            $student->classrooms()->detach($classroomsIds);
        }

        return response()->json([
            'success' => true,
            'message' => 'Estudantes removidos das turmas com sucesso',
        ]);
    }

    public function downloadEvaluations(Request $request)
    {        
        try {
            $studentId = $request->get('student_id');
            $period = $request->get('period');
            $classroomId = $request->get('classroom_id');

            [$start, $end] = explode(' - ', $period);
            $startDate = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();

            $this->clearOldZips();

            $evaluationsQuery = StudentEvaluation::with(
                'student',
                'evaluation',
                'evaluation.classroom',
                'evaluation.evaluationModel.parameters',
                'values',
                'values.value'
            )
                ->where('student_id', $studentId)
                ->whereHas('evaluation', function ($q) use ($startDate, $endDate, $classroomId) {
                    $q->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
                    if ($classroomId !== 'all') {
                        $q->where('classroom_id', $classroomId);
                    }
                });

            $evaluations = $evaluationsQuery->get();

            if ($evaluations->isEmpty()) {
                notify('Não há avaliações para o aluno nesse período.', 'error');
                // return response()->json(['error' => 'Não há avaliações para o aluno nesse período.'], 404);
            }

            if ($classroomId === 'all') {
                return $this->downloadEvaluationsByClassroom($evaluations, $period);
            } else {
                return $this->downloadSingleEvaluation($evaluations, $period);
                
            }
        } catch (\Exception $e) {
            notify('Ocorreu um erro ao processar a solicitação: ' . $e->getMessage(), 'error');
            return response()->json([
                'error' => 'Ocorreu um erro ao processar a solicitação.',
                'message' => $e->getMessage(),
            ], 500);
        } catch (\Throwable $t) {
            notify('Erro inesperado: ' . $t->getMessage(), 'error');
            return response()->json([
                'error' => 'Erro inesperado.',
                'message' => $t->getMessage(),
            ], 500);
        }
    }

    public function fetchEvaluationsByPeriodAndClassroom(Request $request)
    {
        try {
            $studentId = $request->get('student_id');
            $period = $request->get('period');
            $classroomId = $request->get('classroom_id');

            [$start, $end] = explode(' - ', $period);
            $startDate = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();

            $evaluationsQuery = StudentEvaluation::with(
                'student',
                'evaluation',
                'evaluation.classroom',
                'evaluation.evaluationModel.parameters',
                'values',
                'values.value',
                'values.parameter'
            )
                ->where('student_id', $studentId)
                ->whereHas('evaluation', function ($q) use ($startDate, $endDate, $classroomId) {
                    $q->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
                    if ($classroomId !== 'all') {
                        $q->where('classroom_id', $classroomId);
                    }
                });

            return $evaluationsQuery->get();

            
        } catch (\Exception $e) {
            notify('Ocorreu um erro ao processar a solicitação: ' . $e->getMessage(), 'error');
            return response()->json([
                'error' => 'Ocorreu um erro ao processar a solicitação.',
                'message' => $e->getMessage(),
            ], 500);
        } catch (\Throwable $t) {
            notify('Erro inesperado: ' . $t->getMessage(), 'error');
            return response()->json([
                'error' => 'Erro inesperado.',
                'message' => $t->getMessage(),
            ], 500);
        }
    }

    private function downloadEvaluationsByClassroom($evaluations, $period)
    {
        if ($evaluations->isEmpty() || !$evaluations->first()->student) {
            throw new \Exception('Nenhuma avaliação ou aluno encontrado.');
        }

        $evaluationsByClassroom = $evaluations->groupBy('evaluation.classroom.id');
        $student = $evaluations->first()->student;
        $student_name = $student ? $student->full_name : 'Nome desconhecido';

        $pdf = $this->generateEvaluationPdf($evaluationsByClassroom, $period);
    
        $fileName = "avaliacoes_{$student_name}_{$period}.pdf";
        $cleanFileName = $this->cleanFileName($fileName);
        return $pdf->download($cleanFileName);
    }
    

    private function downloadSingleEvaluation($evaluations, $period)
    {
        $student_name = $evaluations->first()->student->full_name;
        $classroom_name = $evaluations->first()->evaluation->classroom->name;

        $evaluationsByClassroom = $evaluations->groupBy('evaluation.classroom.id');
        $sanitizedClassroomName = preg_replace('/[\/\\?%*:|"<>]/', '_', $classroom_name);
        $sanitizedStudentName = preg_replace('/[\/\\?%*:|"<>]/', '_', $student_name);
        $sanitizedPeriod = preg_replace('/[\/\\?%*:|"<>]/', '_', $period);

        $pdf = $this->generateEvaluationPdf($evaluationsByClassroom, $period);

        return $pdf->download("{$sanitizedClassroomName}_{$sanitizedStudentName}_{$sanitizedPeriod}.pdf");
    }

    private function generateEvaluationPdf($allEvaluations, $period)
    {        
        $export = new EvaluationsExport($allEvaluations, $period);
        return $export->generatePdf();
    }

    /**
     * Limpa arquivos ZIP antigos do diretório de armazenamento.
     */
    private function clearOldZips()
    {
        $files = glob(storage_path('app/*.zip'));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    private function cleanFileName($fileName)
    {
        return preg_replace('/[\/\\?%*:|"<>]/', '_', $fileName);  // Substitui caracteres inválidos por '_'
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ModuleService;
use App\Services\UserService;
use App\Services\VideoCourseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\VideoCourseRequest;
use App\Models\Student;
use App\Models\VideoCourse;
use App\Services\FileService;
use App\Services\StudentService;
use App\Services\VideoCourseClassService;
use App\Services\VideoCourseModuleService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class VideoCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getBasicData(Request $request): array
    {

        $course = VideoCourse::find($request->input('id'));

        return [
            'id' => $course->id,
            'name' => $course->title,
            'created_at' => $course->created_at,
            'students' => $course->students->count()
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $user = loggedUser();
        $videoCourses = collect();

        if ($user->is_administrator) {
            $videoCourses = VideoCourseService::getAllVideoCourses();

            return view('video-courses.index', compact('videoCourses'));
        }

        if ($user->is_teacher) {
            $videoCourses = VideoCourseService::getTeacherVideoCourses();

            return view('video-courses.index', compact('videoCourses'));
        }

        $student = selectedStudent();

        if ($user->is_guardian) {
            if ($user->studentsCount > 0) {
                if ($student != null) {
                    $videoCourses = VideoCourseService::getVideoCourseByStudentId($student->id);
                }
            }

            return view('video-courses.index', compact('videoCourses', 'student'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        return view('video-courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoCourseRequest $request)
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $requestData = $request->validated();

        DB::beginTransaction();
        try {
            if (isset($requestData['video_course']['thumbnail'])) {
                $requestData['video_course']['thumbnail'] = FileService::uploadPublicFile($requestData['video_course']['thumbnail'], 'thumbnails');
            }

            if (isset($requestData['video_course']['cover'])) {
                $requestData['video_course']['cover'] = FileService::uploadPublicFile($requestData['video_course']['cover'], 'covers');
            }

            $requestData['video_course']['teacher_access'] = isset($requestData['video_course']['teacher_access']);

            $videoCourse = VideoCourseService::storeVideoCourse($requestData['video_course']);

            if (isset($requestData['video_course_modules']) && $requestData['video_course_modules']) {
                VideoCourseModuleService::storeModules($requestData['video_course_modules'], $videoCourse);
            }

            DB::commit();
            notify('Curso cadastrado com sucesso!');
            return redirect()->route('video-courses.show', $videoCourse->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível cadastrar o curso.', 'error');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VideoCourse $videoCourse): View
    {
        $user = loggedUser();

        if ($user->is_teacher && !$videoCourse->teacher_access) {
            abort(403);
        }

        $modules = $videoCourse->modules()->orderBy('position')->get();

        if ($user->is_administrator || $user->is_teacher) {
            return view('video-courses.show', compact('videoCourse', 'modules'));
        }

        $student = selectedStudent();
        $progress = 0;
        $nextClassLink = VideoCourseClassService::getNextClassLinkByStudentId($videoCourse, $student->id);

        if ($user->is_guardian) {
            if ($user->studentsCount > 0) {
                if ($student != null && $videoCourse->classes_count > 0) {
                    $progress = VideoCourseService::getVideoCourseProgressByStudentId($videoCourse, $student->id);
                }
            }

            return view('video-courses.show', compact('videoCourse', 'modules', 'progress', 'nextClassLink'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(VideoCourse $videoCourse): View
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        return view('video-courses.edit', compact('videoCourse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoCourseRequest $request, VideoCourse $videoCourse)
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $requestData = $request->safe()->except(['video_course.thumbnail', 'video_course.cover']);

        DB::beginTransaction();
        try {

            if ($request->validated('video_course.thumbnail')) {
                if ($videoCourse->thumbnail) {
                    deleteFile($videoCourse->getRawOriginal('thumbnail'));
                }

                $requestData['video_course']['thumbnail'] = FileService::uploadPublicFile($request->validated('video_course.thumbnail'), 'thumbnails');
            }

            if ($request->validated('video_course.cover')) {
                if ($videoCourse->cover) {
                    deleteFile($videoCourse->getRawOriginal('cover'));
                }

                $requestData['video_course']['cover'] = FileService::uploadPublicFile($request->validated('video_course.cover'), 'covers');
            }

            $requestData['video_course']['teacher_access'] = isset($requestData['video_course']['teacher_access']);

            VideoCourseService::updateVideoCourse($videoCourse, $requestData['video_course']);

            DB::commit();
            notify('Curso atualizado com sucesso!');
            return redirect()->route('video-courses.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar o curso solicitado.', 'error');
            return back();
        }
    }

    public function destroy(VideoCourse $videoCourse)
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            VideoCourseService::deleteVideoCourse($videoCourse);

            DB::commit();
            notify('Curso excluído com sucesso!');
            return response()->json([
                'icon' => 'success',
                'msg'  => 'Curso excluído com sucesso!'
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível excluir o curso solicitado.', 'error');
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível excluir o curso solicitado.'
            ]);
        }
    }

    public function addStudent(Request $request): JsonResponse
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $requestData = $request->validate([
            'videoCourseId' => ['required', 'exists:App\Models\VideoCourse,id'],
            'studentId' => ['required', 'exists:App\Models\Student,id'],
        ]);

        DB::beginTransaction();
        try {
            VideoCourseService::addStudent(
                VideoCourseService::getVideoCourseById($requestData['videoCourseId']),
                $requestData['studentId']
            );

            $student = StudentService::getStudentById($requestData['studentId']);
            
            $student->load('videoCourses');

            $student->videoCourses = $student->videoCourses->firstWhere('id', $requestData['videoCourseId']);

            DB::commit();
            
            $data = [
                'student_id' => $student->id,
                'student_start_date' => $student->videoCourses->pivot->created_at,
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
                'msg'  => 'Não foi possível adicionar o aluno solicitado.',
                'error' => $ex->getMessage()
            ], 500);
        }
    }

    public function removeStudent(Request $request): JsonResponse
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $requestData = $request->validate([
            'videoCourseId' => ['required', 'exists:App\Models\VideoCourse,id'],
            'studentId' => ['required', 'exists:App\Models\Student,id'],
        ]);

        DB::beginTransaction();
        try {
            VideoCourseService::removeStudent(
                VideoCourseService::getVideoCourseById($requestData['videoCourseId']),
                $requestData['studentId']
            );

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

    public function viewAllStudents(VideoCourse $videoCourse): View
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $students = StudentService::getStudentsByVideoCourse($videoCourse);

        $oneMonthAgo = Carbon::now()->subMonth();

        $studentsRelantionship = $videoCourse->students()->withPivot('created_at')->get();
        
        $videoCourse->students = $studentsRelantionship->sortByDesc(function ($student) use ($oneMonthAgo) {

            $createdAt = isset($student->pivot->created_at) ? $student->pivot->created_at : $student->created_at;

            return $createdAt  >= $oneMonthAgo ? 1 : 0;
        })->sortByDesc(function ($student) {
            $createdAt = isset($student->pivot->created_at) ? $student->pivot->created_at : $student->created_at;

            return $createdAt;
        });

        return view('video-courses.students', compact('videoCourse', 'students'));
    }
}

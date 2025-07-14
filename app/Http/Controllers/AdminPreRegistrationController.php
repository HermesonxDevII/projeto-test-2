<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Language;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Models\PreRegistration;
use App\Models\VideoCourse;
use App\Services\StudentService;
use App\Services\GuardianService;
use App\Services\ClassroomService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminPreRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function index()
    {

        $preRegistrations = PreRegistration::where('student_id', null)->get();

        return view('pre-registration.index', compact('preRegistrations'));
    }

    public static function show($id)
    {

        $preRegistration = PreRegistration::find($id);

        return view('pre-registration.show', compact('preRegistration'));
    }

    public static function edit($id)
    {

        $preRegistration = PreRegistration::find($id);

        return view('pre-registration.edit', compact('preRegistration'));
    }

    public static function update(Request $request, $id)
    {

        $preRegistration = PreRegistration::find($id);

        DB::beginTransaction();

        try {
            $preRegistration->update([
                'study_plan' => implode(', ', $request->input('study_plan')),
                'student_class' => $request->input('student_class'),
                'student_language' => $request->input('student_language'),
                'guardian_email' => $request->input('guardian_email'),
                'guardian_name' => $request->input('guardian_name'),
                'guardian_phone' => $request->input('guardian_phone'),
                'student_name' => $request->input('student_name'),
                'zipcode' => $request->input('zipcode'),
                'province' => $request->input('province'),
                'city' => $request->input('city'),
                'district' => $request->input('district'),
                'address' => $request->input('address'),
                'complement' => $request->input('complement'),
            ]);

            Db::commit();
            notify('Pré-registro atualizado com sucesso!');

            return redirect()->route('preRegistration.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar o pré-registro solicitado.', 'error');
            return back();
        }
    }

    public static function destroy(Request $request)
    {

        $preRegistration = PreRegistration::find($request->input('id'));

        DB::beginTransaction();

        try {
            $preRegistration->delete();

            Db::commit();
            notify('Pré-registro excluído com sucesso!');

            return redirect()->route('preRegistration.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível excluir o pré-registro solicitado.', 'error');
            return back();
        }
    }

    public static function approve($id)
    {

        $preRegistration = PreRegistration::find($id);

        $classrooms = ClassroomService::getAllClassrooms();

        $courses = VideoCourse::all();

        return view('pre-registration.approve', compact('preRegistration', 'classrooms', 'courses'));
    }

    public static function approveStore(Request $request)
    {
        $requestData = $request->all();
        $preRegistration = PreRegistration::find($requestData['preRegistrationId']);

        if ($preRegistration->student_id != null) {
            return response()->json([
                'success' => false,
                'message' => 'Aluno já aprovado!'
            ]);
        }

        $classroomsExist = isset($requestData['classrooms']) && !empty($requestData['classrooms']);
        $coursesExist = isset($requestData['courses']) && !empty($requestData['courses']);

        if (!$classroomsExist && !$coursesExist) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor, insira ao menos uma turma ou curso.'
            ]);
        }

        DB::beginTransaction();

        try {
            $guardian = User::where('email', $preRegistration->guardian_email)->withTrashed()->first();
            if (!$guardian) {
                $guardian_data = [
                    'name' => $preRegistration->guardian_name,
                    'email' => $preRegistration->guardian_email,
                    'phone_number' => $preRegistration->guardian_phone,
                    'address' => [
                        'zip_code' => $preRegistration->zipcode,
                        'province' => $preRegistration->province,
                        'city' => $preRegistration->city,
                        'district' => $preRegistration->district,
                        'number' => $preRegistration->address,
                        'complement' => $preRegistration->complement,
                    ]
                ];

                $guardian = GuardianService::storeGuardian($guardian_data);
            } else {
                if ($guardian->trashed()) {
                    $guardian->restore();
                }
            }

            if ($classroomsExist) {
                $classroomIds = $requestData['classrooms'];
                $classroomCounts = array_count_values($classroomIds);
                foreach ($classroomCounts as $classroomId => $count) {
                    if ($count > 1) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Aluno não pode estar registrado em duas turmas iguais!'
                        ]);
                    }
                }
            }

            if ($coursesExist) {
                $courseIds = $requestData['courses'];
                $courseCounts = array_count_values($courseIds);
                foreach ($courseCounts as $courseId => $count) {
                    if ($count > 1) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Aluno não pode estar registrado em dois cursos iguais!'
                        ]);
                    }
                }
            }

            $language = Language::where('name', $preRegistration->student_language)->first();
            $grade = Grade::where('name', $preRegistration->student_class)->first();

            if (is_int($guardian)) {
                $guardian = User::find($guardian);
            }

            $student_data = [
                'full_name' => $preRegistration->student_name,
                'email' => $preRegistration->guardian_email,
                'grade_id' => $grade->id,
                'domain_language_id' => $language->id,
                'avatar_id' => 0,
                'send_email' => false,
                'classrooms' => $classroomsExist ? $requestData['classrooms'] : [],
                'courses' => $coursesExist ? $requestData['courses'] : [],
                'guardian_id' => $guardian->id,
            ];

            $student_id = StudentService::storeStudent($student_data);

            $preRegistration->update([
                'student_id' => $student_id,
            ]);

            DB::commit();

            $student = StudentService::getStudentById($student_id);

            $weekDays = [];

            foreach ($student->classrooms as $classroom) {
                $weekDays = array_merge($weekDays, explode(',', $classroom->weekDays));
            }

            $uniqueWeekDays = implode(', ', array_unique(array_map('trim', $weekDays)));

            $classroom_and_course_names = [];

            foreach ($student->classrooms as $classroom) {
                array_push($classroom_and_course_names, $classroom->name);
            }

            foreach ($student->videoCourses as $course) {
                array_push($classroom_and_course_names, $course->title);
            }

            $classroom_names = implode(', ', $classroom_and_course_names);

            return response()->json([
                'success' => true,
                'message' => 'Aluno aprovado com sucesso!',
                'student_name' => $student->full_name,
                'student_id' => $student->id,
                'grade_name' => $student->grade->name,
                'classroom_names' => $classroom_names,
                'weekDays' => $uniqueWeekDays,
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    public static function sendWelcome(Request $request)
    {
        $data = $request->all();
        $student = Student::find($data['student_id']);
        $guardian = $student->guardian;

        try {

            Mail::to($guardian->email)->send(new WelcomeMail($guardian->id, $student->full_name));

            return response()->json([
                'icon' => 'success',
                'msg'  => 'E-mail enviado com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'icon' => 'error',
                'msg'  => $ex->getMessage()
            ], 500);
            // return response()->json([
            //     'icon' => 'error',
            //     'msg'  => 'Não foi possível enviar o e-mail.'
            // ], 500);
        }
    }
}

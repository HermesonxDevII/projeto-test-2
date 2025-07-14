<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreRegistrationTemporaryRequest;
use App\Models\Grade;
use App\Models\Language;
use App\Models\PreRegistrationTemporary;
use App\Models\User;
use App\Models\VideoCourse;
use App\Services\GuardianService;
use App\Services\PreRegistrationTemporaryService;
use App\Services\StudentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PreRegistrationTemporaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke($courses = false)
    {
        if($courses === 'courses')
        {
            $courses = true;
        }

        return view('event-pre-registration.form', ['courses' => $courses]);
    }

    public static function store(Request $request)
    {

        $preRegistrationRequest = new PreRegistrationTemporaryRequest();

        $validator = Validator::make($request->all(), $preRegistrationRequest->rules(), $preRegistrationRequest->messages());

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }

        $preRegistration = PreRegistrationTemporary::create($request->all());

        DB::beginTransaction();

        try {
            // cria o responsavel (guardian)
            $guardian = User::where('email', $preRegistration->guardian_email)->withTrashed()->first();
            if (!$guardian) {
                $guardian_data = [
                    'name' => $preRegistration->guardian_name,
                    'email' => $preRegistration->guardian_email,
                    'phone_number' => $preRegistration->guardian_phone,
                    'address' => [                        
                        'province' => $preRegistration->province,
                    ],
                    'work_company' => $preRegistration->work_company
                ];

                $guardian = GuardianService::storeGuardian($guardian_data);
            } else {
                if ($guardian->trashed()) {
                    $guardian->restore();
                }
            }

            // cria o estudante
            $language = Language::where('name', $preRegistration->student_language)->first();
            $grade = Grade::where('name', $preRegistration->student_class)->first();

            $courses = VideoCourse::whereIn('id', [9,10,11,12,13,14,15,16])->get();

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
                'classrooms' => [],
                'courses' => $courses ? $courses : [],
                'guardian_id' => $guardian->id,
            ];

            $student_id = StudentService::storeStudent($student_data);

            $preRegistration->update([
                'student_id' => $student_id,
            ]);

            DB::commit();

            $student = StudentService::getStudentById($student_id);

            // adicionando validade de acesso
            $dataAtual = Carbon::now();
            $expires_at = $dataAtual->addMonthNoOverflow();

            $student->update([
                'expires_at' => $expires_at->format('y-m-d')
            ]);

            // envia email para acesso aos dados
            PreRegistrationTemporaryService::sendAccessEmail($guardian);

            return response()->json([
                'status' => 'success',
                'message' => 'Aluno aprovado com sucesso!'
            ]);

        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ]);
        }
    }
}

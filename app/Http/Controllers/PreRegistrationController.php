<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PreRegistration;
use Illuminate\Support\Facades\{ Validator, Log };
use App\Http\Requests\PreRegistrationRequest;

class PreRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke($courses = false, $program = false)
    {
        if ($courses === 'courses') {
            $courses = true;
        }

        $programSelected = false;

        if ($program === 'MentoringLearningToStudy') {
            $programSelected = 'MAE';

            return view('pre-registration.mentoring-learning-to-study.form', [
                'courses' => $courses,
                'programSelected' => $programSelected
            ]);

        } elseif ($program === 'SchoolMonitoringProgram') {
            $programSelected = 'PAE';

            return view('pre-registration.school-monitoring-program.form', [
                'courses' => $courses,
                'programSelected' => $programSelected
            ]);
        }

        return view('pre-registration.form', [
            'courses' => $courses,
            'programSelected' => $programSelected
        ]);
    }

    public static function store(Request $request)
    {
        $preRegistrationRequest = new PreRegistrationRequest();

        $validator = Validator::make($request->all(), $preRegistrationRequest->rules(), $preRegistrationRequest->messages());

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }

        PreRegistration::create($request->all());

        return response()->json([
            'status' => 'success',
        ]);
    }

    public static function tryGetAddressByEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user != null) {

            $address = $user->address()->first();

            if ($address != null) {
                return response()->json([
                    'message' => 'success',
                    'data' => $address,
                ]);
            }
        }
    }
}

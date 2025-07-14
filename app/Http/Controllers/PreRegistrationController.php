<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PreRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PreRegistrationRequest;

class PreRegistrationController extends Controller
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

        return view('pre-registration.form', ['courses' => $courses]);
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

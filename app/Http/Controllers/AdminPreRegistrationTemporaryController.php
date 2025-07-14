<?php

namespace App\Http\Controllers;

use App\Models\PreRegistrationTemporary;
use Illuminate\Http\Request;

class AdminPreRegistrationTemporaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function show($id)
    {

        $preRegistration = PreRegistrationTemporary::find($id);

        return view('pre-registration.show', compact('preRegistration'));
    }
}

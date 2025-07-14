<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AcessLog;
use App\Models\User;
use App\Services\GuardianService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->is_guardian && !GuardianService::hasDoesntExpiredStudents($user)) {
            if (GuardianService::hasActiveStudents($user)) {
                GuardianService::inactiveExpiredStudents($user);
            }

            return back()->withErrors([
                'email' => 'Seu acesso está expirado procure nosso suporte.',
            ])->onlyInput('email');
        }

        if ($user && $user->is_guardian && !GuardianService::hasActiveStudents($user)) {
            return back()->withErrors([
                'email' => 'Seu acesso está inativado procure nosso suporte.',
            ])->onlyInput('email');
        }

        if ($user && $user->is_guardian && !GuardianService::hasAnyStudentWithAccess($user)) {
            GuardianService::inactiveExpiredStudents($user);

            return back()->withErrors([
                'email' => 'Seu acesso está inativado procure nosso suporte.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = $user->isAdministrator ? 'admin' :
                ($user->isTeacher ? 'teacher' :
                ($user->isGuardian ? 'guardian' : 'unknown'));

            AcessLog::create([
                'user_id' => auth()->id(),
                'student_id' => null, // será preenchido depois, se for responsável e selecionar um aluno
                'role' => $role,
                'accessed_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended('dashboard');
        } else {
            if ($user) {
                return back()->withErrors([
                    'password' => 'Senha incorreta.',
                    'login_error' => "E-mail ou senha incorretos. Por favor, verifique se os dados estão corretos. Se não lembrar, clique em 'Recuperar senha' para redefinir.",
                ])->onlyInput('email');
            } else {
                return back()->withErrors([
                    'email' => 'E-mail não encontrado.',
                    'login_error' => "E-mail ou senha incorretos. Por favor, verifique se os dados estão corretos. Se não lembrar, clique em 'Recuperar senha' para redefinir.",
                ]);
            }
        }
    }

    protected function authenticated(Request $request, $user)
    {
        $request->session()->put('user_role_id', $user->roles->first()->id);
        $request->session()->put('user_id', $user->id);

        if ($user->is_administrator) {
            return redirect()->route('dashboard');
        } else if ($user->is_guardian) {
            if ($user->studentsCount > 1) {
                return redirect()->route('students.chooseStudent');
            } else if ($user->studentsCount == 0) {
                return redirect()->route('dashboard');
            } else {
                //
                $studentList = $user->students;
                $student = $studentList->where('status', 1)->first();
                $request->session()->put('student_id', $student->id);
                $request->session()->put('student_name', $student->formattedFullName);
                $request->session()->put('student_nickname', $student->nickname);
                $request->session()->put('student_avatar_id', $student->avatar_id);
                return redirect()->route('dashboard');
            }
        }
        return redirect()->route('dashboard');
    }
}

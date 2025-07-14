<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\WelcomeMail;
use App\Mail\SendAccessMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use App\Models\{User, Language, Grade, Student};
use Illuminate\Http\{JsonResponse, Request, RedirectResponse};
use App\Services\{ClassroomService, GuardianService, StudentService};
use App\Http\Requests\{AddStudentRequest, GuardianRequest, StudentRequest};

class GuardianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $user = loggedUser();

        $query = User::query()
            ->whereHas('roles', function ($q) {
                $q->where('role_id', 3);
            })
            ->with('consultancy')            
            ->isActive(1);

        if ($request->filled('grade_id')) {
            $gradeId = $request->input('grade_id');
            $query->whereHas('students', function ($q) use ($gradeId) {
                $q->where('grade_id', $gradeId);
            });
        }

        if ($request->filled('classroom_id')) {
            $classroomId = $request->input('classroom_id');
            $query->whereHas('students.classrooms', function ($q) use ($classroomId) {
                $q->where('classroom_id', $classroomId);
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->whereHas('students', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        if ($request->filled('period')) {
            [$start, $end] = explode(' - ', $request->period);
            $start = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();

            $query->whereHas('students', function ($q) use ($start, $end) {
                $q->whereBetween('created_at', [$start, $end]);
            });
        }

        if ($user->is_administrator) {
            $students = StudentService::getAllStudents();
            $classrooms = ClassroomService::getAllClassrooms();
            $grades = Grade::all();
        } else {
            $students = StudentService::getStudentsByTeacherId($user->id);
            $classrooms = [];
            $grades = [];
        }

        $guardians = $query->get();

        return view('guardians.index', compact('guardians', 'students', 'classrooms', 'grades'));
    }


    public function create(): View
    {
        $this->authorize('create', User::class);
        return view('guardians.create');
    }

    public function store(GuardianRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);
        DB::beginTransaction();
        try {
            GuardianService::storeGuardian($request->validated());

            DB::commit();
            notify('Responsável cadastrado com sucesso!');

            return redirect()->route('guardians.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível cadastrar o responsável solicitado.', 'error');
            return back()->withInput($request->input());
        }
    }

    public function show(User $user): View
    {
        $this->authorize('view', User::class);
        return view('guardians.show')->with(['guardian' => $user]);
    }

    public function edit(User $user): view
    {
        $this->authorize('update', $user);

        $data = [
            'guardian' => $user,
            'address' => $user->address->first(),
            'full_address' => $user->full_address
        ];

        return view('guardians.edit', compact('data'));
    }

    public function update(GuardianRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);
        DB::beginTransaction();
        try {
            GuardianService::updateGuardian($request->all(), $user);

            Db::commit();
            notify('Responsável atualizado com sucesso!');

            return redirect()->route('guardians.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar o responsável solicitado.', 'error');
            return back()->withInput($request->input());
        }
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);

        DB::beginTransaction();
        try {
            GuardianService::deleteGuardian($user);

            DB::commit();
            return response()->json([
                'icon' => 'success',
                'msg'  => 'Responsável excluído com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível excluir o responsável solicitado.'
            ], 500);
        }
    }

    public function forceDelete(User $user): void
    {
        $this->authorize('forceDelete', User::class);
        GuardianService::forceDeleteGuardian($user);
    }

    public function restore(User $user): void
    {
        $this->authorize('restore', User::class);
        GuardianService::restoreGuardian($user);
    }

    public function addStudent(User $user): View
    {
        $this->authorize('create', Student::class);

        $data = [
            'guardian' => $user,
            'grades' => Grade::all()->sortBy("name"),
            'languages' => Language::all(),
            'classrooms' => ClassroomService::getAllClassrooms()
        ];

        return view('guardians.forms.addStudents', compact('data'));
    }

    public function addStudentToGuardian(User $user, AddStudentRequest $request): RedirectResponse
    {
        $this->authorize('create', Student::class);

        DB::beginTransaction();
        try {
            $requestData = $request->all();
            $requestData['student']['guardian_id'] = $user->id;

            StudentService::storeStudent(
                array_merge(
                    $requestData['student'],
                    ['guardian_id' => $user->id]
                )
            );

            DB::commit();

            if ($requestData['student']['send_email'] == '1') {
                Mail::to($user->email)->send(new WelcomeMail($user->id, $requestData['student']['full_name']));
            }

            notify('Aluno adicionado com sucesso!');
            return redirect()->route('guardians.show', $user->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível adicionar o aluno solicitado.', 'error');
            return back();
        }
    }

    public function sendAccessEmail(User $user): JsonResponse
    {
        DB::beginTransaction();
        try {

            GuardianService::changePasswordGuardian($user);

            DB::commit();
            Mail::to($user->email)->send(new SendAccessMail($user));

            return response()->json([
                'icon' => 'success',
                'msg'  => 'Nova senha enviada por email com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível enviar uma nova senha.'
            ], 500);
        }
    }

    public function consultancyUpdate(Request $request, User $user): JsonResponse 
    {        
        $this->authorize('delete', $user);
        DB::beginTransaction();
        try {
            
            GuardianService::updateGuardianConsultancy($request->boolean('has_consultancy'), $user);

            Db::commit();

            return response()->json([
                'icon' => 'success',
                'msg'  => 'Responsável atualizado!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => "Não foi possível atualizar o responsável solicitado. {$ex->getMessage()}"
            ], 500);
        }
    }
}

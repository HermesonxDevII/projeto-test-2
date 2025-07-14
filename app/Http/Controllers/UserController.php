<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Role, Student};
use App\Services\{StudentService, UserService};
use Illuminate\Support\Facades\{DB, Auth};
use App\Http\Requests\{StudentRequest, UserRequest};
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $this->authorize('viewAny', User::class);
        $users = UserService::getAllUsers([1, 2]);
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);
        $roles = Role::whereIn('id', [1, 2])->get();
        return view('users.create', compact('roles'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);
        DB::beginTransaction();
        try {
            $user = UserService::storeUser($request);

            DB::commit();
            notify('Usuário cadastrado com sucesso!');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível cadastrar o usuário solicitado.', 'error');
        }
        return redirect()->route('users.index');
    }

    public function show(User $user): View
    {
        $this->authorize('view', User::class);
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        $roles = Role::whereIn('id', [1, 2])->get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);
        DB::beginTransaction();
        try {
            UserService::updateUser($request, $user);

            DB::commit();
            notify('Usuário atualizado com sucesso!');

            if (!$user->is_administrator) {
                return redirect()->route('dashboard');
            }
        } catch (\Exception $ex) {

            DB::rollBack();
            notify('Não foi possível atualizar o usuário solicitado.', 'error');
            return back();
        }
        return redirect()->route('users.index');
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);

        DB::beginTransaction();
        try {
            UserService::deleteUser($user);

            DB::commit();
            return response()->json([
                'icon' => 'success',
                'msg'  => 'Usuário excluído com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível excluir o usuário solicitado.'
            ], 500);
        }
    }

    public function restore(User $user): RedirectResponse
    {
        $this->authorize('restore', User::class);

        DB::beginTransaction();
        try {
            User::restoreUser($user);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
        }
        return redirect()->route('users.index');
    }

    public function getUser(Request $request)
    {
        return UserService::getUsers($request)->first();
    }

    public function myProfile()
    {
        $user = loggedUser();

        if ($user->is_administrator || $user->is_teacher) {
            $people = $user;
        } else if ($user->is_guardian) {
            if ($user->studentsCount > 0) {
                $student = selectedStudent();

                if ($student == null) {
                    return redirect()->route('students.chooseStudent');
                }

                $people = $student;
            } else {
                $people = $user;
            }
        }

        return view('users.forms.profile')->with([
            'user' => $user,
            'people' => $people,
            'people_type' => class_basename($people)
        ]);
    }

    public function getStudents(): Collection
    {
        return loggedUser()->students;
    }
}

<?php

namespace App\Policies;

use App\Models\{Student, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return ($user->is_administrator || $user->is_teacher)
            && $user->status;
    }

    public function view(User $user)
    {
        return ($user->is_administrator || $user->is_teacher)
            && $user->status;
    }

    public function create(User $user)
    {
        return $user->is_administrator && $user->status;
    }

    public function update(User $user, Student $student)
    {
        return $user->is_administrator || $user->id === $student->guardian_id
            && $user->status;
    }

    public function delete(User $user)
    {
        return $user->is_administrator && $user->status;
    }

    public function restore(User $user, Student $student)
    {
        return $user->is_administrator && $user->status;
    }

    public function forceDelete(User $user, Student $student)
    {
        return $user->is_administrator && $user->status;
    }
}

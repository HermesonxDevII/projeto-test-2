<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassroomPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function view(User $user, Classroom $classroom)
    {
        return ($user->is_administrator 
                || ($user->is_teacher && $classroom->hasCoursesWithTeacherId($user->id, 1))
                || ($user->is_guardian && $user->studentsClassrooms->contains($classroom->id))
            ) && $user->status;
    }

    public function create(User $user)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function update(User $user, Classroom $classroom)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function delete(User $user, Classroom $classroom)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function restore(User $user, Classroom $classroom)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function forceDelete(User $user, Classroom $classroom)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function addStudent(User $user)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function removeStudent(User $user)
    {
        return $user->is_administrator
            && $user->status;
    }
}

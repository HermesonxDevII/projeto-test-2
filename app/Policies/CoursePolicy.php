<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function view(User $user, Course $course)
    {
        return ($user->is_teacher && $course->teacher_id === $user->id)
            || $user->is_administrator && $user->status;
    }

    public function create(User $user)
    {
        return ($user->is_teacher || $user->is_administrator) && $user->status;
    }

    public function update(User $user)
    {
        return $user->status && ($user->is_teacher || $user->is_administrator);
    }

    public function delete(User $user)
    {
        return $user->status && ($user->is_teacher || $user->is_administrator);
    }

    public function restore(User $user)
    {
        return $user->status && ($user->is_teacher || $user->is_administrator);
    }

    public function forceDelete(User $user)
    {
        return $user->is_administrator && $user->status;
    }
}

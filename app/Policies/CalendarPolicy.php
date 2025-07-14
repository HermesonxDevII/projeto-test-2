<?php

namespace App\Policies;

use App\Models\{Calendar, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return ($user->is_administrator || $user->is_teacher) && $user->status;
    }

    public function view(User $user, Calendar $calendar)
    {
        return ($user->is_administrator || $user->is_teacher || $user->is_guardian) && $user->status;
    }

    public function create(User $user)
    {
        return $user->is_administrator && $user->status;
    }

    public function update(User $user, Calendar $calendar)
    {
        return $user->is_administrator && $user->status;
    }

    public function delete(User $user)
    {
        return $user->is_administrator && $user->status;
    }

    public function restore(User $user)
    {
        return $user->is_administrator && $user->status;
    }

    public function forceDelete(User $user)
    {
        return $user->is_administrator && $user->status;
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function view(User $user)
    {
        return $user->is_administrator 
            && $user->status;
    }

    public function create(User $user)
    {
        return $user->is_administrator
            && $user->status;
    }

    public function update(User $user, User $userToUpdate)
    {
        return ($user->is_administrator || $user->id === $userToUpdate->id)
            && $user->status;
    }
    
    public function delete(User $user, User $userToDelete)
    {
        return $user->is_administrator
            && $user->id != $userToDelete->id 
            && $user->status;
    }

    public function restore(User $user)
    {
        return $user->is_administrator 
            && $user->status;
    }

    public function forceDelete(User $user)
    {
        return $user->is_administrator 
            && $user->status;
    }
}

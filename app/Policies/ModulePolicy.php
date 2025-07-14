<?php

namespace App\Policies;

use App\Models\Module;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModulePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Module $module)
    {
        //
    }

    public function create(User $user)
    {
        return ($user->is_administrator || $user->is_teacher)
            && $user->status;
        }
        
    public function update(User $user, Module $module)
    {
        return ($user->is_administrator || $user->is_teacher)
            && $user->status;
    }

    public function delete(User $user, Module $module)
    {
        return ($user->is_administrator || $user->is_teacher)
            && $user->status;
    }

    public function restore(User $user, Module $module)
    {
        //
    }

    public function forceDelete(User $user, Module $module)
    {
        //
    }
}

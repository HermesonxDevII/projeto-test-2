<?php

namespace App\Policies;

use App\Models\{File, User, Material};
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;
    
    public function getMaterial(User $user, Material $material)
    {        
        return ($user->is_administrator || $user->is_teacher || ($user->is_guardian && $user->studentsClassrooms->contains($material->course->classroom->id)))
            && $user->status;
    }

    public function downloadFile(User $user, File $file)
    {
        # code...
    }
}

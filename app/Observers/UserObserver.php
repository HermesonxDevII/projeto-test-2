<?php

namespace App\Observers;

use App\Models\PreRegistrationTemporary;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        // Obtém o e-mail antes da alteração
        $oldEmail = $user->getOriginal('email');

        // Criamos um clone do usuário antes da alteração
        $originalUser = clone $user;
        $originalUser->email = $oldEmail;

        // Agora verificamos a condição no estado original
        if ($user->isDirty('email') && $originalUser->hasValidPreRegistrationTemporary()) {

            PreRegistrationTemporary::where('guardian_email', $oldEmail)
                ->update(['guardian_email' => $user->email]);
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}

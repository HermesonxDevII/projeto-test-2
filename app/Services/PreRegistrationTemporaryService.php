<?php

namespace App\Services;

use App\Models\{ User};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendAccessMail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class PreRegistrationTemporaryService
{
    public static function sendAccessEmail(User $user): array
    {
        DB::beginTransaction();
        try {

            $newPassword = Crypt::encryptString(Str::random(8));
            $user->password = $newPassword;
            $user->update();

            DB::commit();
            Mail::to($user->email)->send(new SendAccessMail($user));

            return [
                'success' => true
            ];
        } catch (\Exception $ex) {
            DB::rollBack();
            return [
                'success' => false
            ];
        }
    }
}
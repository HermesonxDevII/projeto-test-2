<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{Address, User, Student};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class GuardianService
{
    public static function getGuardians(int $status = null): Collection
    {
        $guardians = User::whereHas('roles', function ($q) {
            $q->where('role_id', 3);
        });

        if ($status != null) {
            $guardians = $guardians->isActive($status);
        }

        return $guardians->get();
    }

    public static function getGuardian(Request $request): Collection
    {
        $guardian = User::with('address')->with('roles');

        $guardian = $guardian->whereHas("roles", function ($q) {
            $q->where("roles.id", "3");
        });

        if (isset($request->id)) {
            $guardian = $guardian->whereId($request->id);
        }

        if (isset($request->email)) {
            $guardian = $guardian->whereEmail($request->email);
        }

        return $guardian->get()->first();
    }

    public static function storeGuardian(array $requestData): int
    {        
        $guardian = User::where('email', $requestData['email'])->withTrashed()->first();

        if (!$guardian) {
            $requestData['password'] = Crypt::encryptString(Str::random(8));

            $guardian = User::create($requestData);

            Address::create(
                array_merge($requestData['address'], ['user_id' => $guardian->id])
            );
    
            $guardian->roles()->attach(3);

        } else {
            if ($guardian->trashed()) {
                $guardian->restore();               
            }
                
            if (!$guardian->roles()->where('role_id', 3)->exists()) {
                $guardian->roles()->attach(3);
            }
        }
        
        
        return $guardian->id;
    }

    public static function updateGuardian(array $requestData, User $user): void
    {

        $user->update($requestData);

        $user->address()->update(
            $requestData['address']
        );
    }

    public static function deleteGuardian(User $user): void
    {
        $user->delete();
    }

    public static function forceDeleteGuardian(User $user): void
    {
        $user->forceDelete();
    }

    public static function restoreGuardian(User $user): void
    {
        $user->restore();
    }

    public static function changePasswordGuardian(User $user): void
    {
        $newPassword = Crypt::encryptString(Str::random(8));
        $user->password = $newPassword;
        $user->update();
    }

    public static function inactiveExpiredStudents(User $user): bool
    {
        return Student::where('guardian_id', $user->id)
            ->whereDate('expires_at', '<=', now()->format('Y-m-d'))
            ->update(['status' => false]);
    }

    public static function hasDoesntExpiredStudents(User $user): bool
    {
        return Student::where('guardian_id', $user->id)
            ->where(function ($q) {
                $q->whereDate('expires_at', '>', now()->format('Y-m-d'))
                    ->orWhereNull('expires_at');
            })
            ->exists();
    }

    public static function hasActiveStudents(User $user): bool
    {
        return Student::where('guardian_id', $user->id)
            ->where('status', true)
            ->exists();
    }

    public static function hasAnyStudentWithAccess(User $user): bool
    {
        return Student::where('guardian_id', $user->id)
            ->where(function ($q) {
                $q->whereDate('expires_at', '>', now()->format('Y-m-d'))
                    ->orWhereNull('expires_at');
            })
            ->where('status', true)
            ->exists();
    }

    public static function updateGuardianConsultancy(bool $has_consultancy, User $user): void
    {
        
        $guardian = $user->load('consultancy');
        
        if($guardian->consultancy) {
            $guardian->consultancy()->update(['has_consultancy' => $has_consultancy]);
        } else {
            $guardian->consultancy()->create(['has_consultancy' => $has_consultancy]);
        }
    }
}

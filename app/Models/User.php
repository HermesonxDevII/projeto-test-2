<?php

namespace App\Models;

use App\Services\UserService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\{ HasMany };
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use App\Mail\ResetPasswordMail;
use App\Models\{ Meeting };

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes;

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'login',
        'status',
        'profile_photo',
        'work_company'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'guardian_id');
    }

    public function consultancy()
    {
        return $this->hasOne(UserConsultancy::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'schedule_id');
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class)->withTimeStamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::Class);
    }

    // Accessors
    protected function isAdministrator(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->roles->contains(1)
        );
    }

    protected function isTeacher(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->roles->contains(2)
        );
    }

    protected function isGuardian(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->roles->contains(3)
        );
    }

    protected function formattedName(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->name
        );
    }

    protected function nameInitial(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->name[0]
        );
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => explode(' ', $this->formattedName)[0]
        );
    }

    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => UserService::getFullAddress($this)
        );
    }

    protected function studentsList(): Attribute
    {
        $students = $this->students;

        return Attribute::make(
            get: fn ($value) => $students->count() > 0 ? $students->implode('formattedFullName', ', ') : '-'
        );
    }

    protected function studentsClassrooms(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Classroom::whereHas('students', function ($q) {
                $q->where('guardian_id', $this->id);
            })->get()->pluck('id')
        );

        // SELECT C.ID FROM CLASSROOMS C
        //     INNER JOIN STUDENT_CLASSROOM SC ON SC.CLASSROOM_ID = C.ID
        //     INNER JOIN STUDENTS S ON S.ID = SC.STUDENT_ID
        // WHERE S.GUARDIAN_ID = ? ORDER BY C.ID ASC;
    }

    protected function studentsCourses(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Course::whereHas('classroom.students', function ($q) {
                $q->where('guardian_id', $this->id)->where('status', 1);
            })->get()->pluck('id')
        );

        // SELECT DISTINCT(CS.ID) FROM STUDENTS S
        //     INNER JOIN STUDENT_CLASSROOM SC ON SC.STUDENT_ID = S.ID
        //     INNER JOIN COURSES CS ON CS.CLASSROOM_ID = SC.CLASSROOM_ID
        // WHERE S.ID IN (SELECT ID FROM STUDENTS WHERE GUARDIAN_ID = ?)
        //     AND S.STATUS = 1 ORDER BY CS.ID ASC;
    }

    public function studentsCount(int $status = 1): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->students->where('status', $status)->count()
        );
    }

    // Scopes
    public function scopeIsActive($query, int $status = 1): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeHasRoles($query, array $roles): Builder
    {
        return $query->whereHas('roles', function ($q) use ($roles) {
            $q->whereIn('role_id', $roles);
        });
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)->send(new ResetPasswordMail($this, $token));
    }

    public function hasValidPreRegistrationTemporary(): bool
    {
        return PreRegistrationTemporary::where('guardian_email', $this->email)->exists();        
    }
}

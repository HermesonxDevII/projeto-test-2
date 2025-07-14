<?php
namespace App\Providers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\{Classroom, Course, User, Student, Material, Module};
use App\Policies\{ClassroomPolicy, CoursePolicy, FilePolicy, ModulePolicy, UserPolicy, StudentPolicy};
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class      => UserPolicy::class,
        Student::class   => StudentPolicy::class,
        Classroom::class => ClassroomPolicy::class,
        Course::class    => CoursePolicy::class,
        Material::class  => FilePolicy::class,
        Module::class    => ModulePolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('customcs', function ($app, array $config) {
            return $app->make(CustomEloquentUserProvider::class, ['model' => $config['model']]);
        });

        Gate::define('admin', function($user) {
            return $user->is_administrator;
        });

        Gate::define('guardian', function($user) {
            return $user->is_guardian;
        });

        Gate::define('teacher', function($user) {
            return $user->is_teacher;
        });
    }
}

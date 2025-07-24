<?php

namespace App\Providers;

use App\Models\{ User, Classroom };
use App\Observers\{ UserObserver, ClassroomObserver };
use Illuminate\Support\Facades\{ URL, Blade };
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment(['production', 'homolog'])) {
            URL::forceScheme('https');
        }

        User::observe(UserObserver::class);

        Classroom::observe(ClassroomObserver::class);
        
        Blade::anonymousComponentPath(resource_path('views/classrooms/components'), 'classroom');
    }
}

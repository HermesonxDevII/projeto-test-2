<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\Classroom;
use App\Observers\ClassroomObserver;

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
        
    }
}

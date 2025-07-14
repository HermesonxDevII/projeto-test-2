<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\getTodayCourses::class,
        Commands\clearCourseNotifications::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:get-today-courses')->everyFifteenMinutes()->timezone('Asia/Tokyo');
        $schedule->command('command:clear-courses-notifications')->weeklyOn(1, '00:01')->timezone('Asia/Tokyo');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

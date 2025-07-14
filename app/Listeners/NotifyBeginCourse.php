<?php

namespace App\Listeners;

use App\Events\CourseStartNotification;
use App\Jobs\NotifyStartCourseToUsers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyBeginCourse
{
    public function __construct()
    {
        //
    }

    public function handle(CourseStartNotification $event)
    {
        // return dd($event);
        // cron job para notificar o inicio da aula - 10 min
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\{DB, Auth};
use Carbon\Carbon;
use App\Models\CourseNotification;
use Pusher\Pusher;

class getTodayCourses extends Command
{
    protected $signature = 'command:get-today-courses';
    protected $description = 'Get Today Courses';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            array(
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true
            )
        );

        $todayCourses = Course::whereHas('schedules.weekday', function ($q) {
            $q->where([
                ['weekday_number', Carbon::now()->weekday()],
                ['status', 1],
                ['start', '<=', Carbon::now()->addMinutes(15)],
                ['start', '>=', Carbon::now()]
            ]);
        })->select(['id', 'name', 'link', 'type', 'start'])->orderBy('updated_at','desc')->get();

        foreach ($todayCourses as $key => $course) {
            $start = Carbon::parse($course->start)->format('H:i');

            CourseNotification::updateOrCreate(
                ['course_id' => $course->id],
                [
                    'title' => "Sua aula {$course->formattedName} começará hoje às {$start}.",
                    'message' => 'Não esqueça de acessar a aula.',
                    'course_id' => $course->id
                ]
            );

            $pusher->trigger("course-{$course->id}-notifications", 'App\\Events\\CourseStartNotification', $course);
        }
    }
}

<?php

namespace App\Jobs;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\{ShouldBeUnique, ShouldQueue};
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\DB;
use App\Models\Language;

class NotifyStartCourseToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function handle()
    {
        // return dd($this->course);

        // DB::table('temp')->insert(
        //     array(
        //         'id' => random_int(1, 1000000),
        //         'course_id' => $this->course->id
        //     )
        // );
    }
}

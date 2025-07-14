<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class clearCourseNotifications extends Command
{
    protected $signature = 'command:clear-courses-notifications';
    protected $description = 'Clear Courses Notifications table';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        DB::table('course_notifications')->delete();
    }
}

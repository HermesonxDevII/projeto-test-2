<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{Course, CourseNotification};
use DB;

class CourseNotificationService
{
    public static function getAllCoursesNotifications()
    {
        return CourseNotification::all();
    }

    public static function getNotificationByCourse(Course $course)
    {
        return $course->notification;
    }

    public static function getWeeklyNotificationsByStudentSelected(int $courseType = 2)
    {
        $courses = StudentService::getCoursesOfSelectedStudent($courseType)->pluck('id');
        return CourseNotification::whereIn('course_id', $courses)->orderBy('updated_at','desc')->get();
    }
}

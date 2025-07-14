<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\{ClassroomService, CourseService, StudentService, UserService, VideoCourseService};
use Illuminate\Contracts\View\View;
use App\Events\CourseStartNotification;
use App\Models\AcessLog;
use App\Models\Student;
use App\Models\VideoCourse;
use Pusher\Pusher;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View|RedirectResponse
    {
        $statistics = [];
        $user = loggedUser();
        $student = selectedStudent();
        $recent_courses = null;
        $classrooms = null;

        if ($user->is_administrator)
        {
            $statistics = [
                'students'     => StudentService::getAllActiveStudents()->count(),
                // 'students'     => StudentService::getAllStudents()->count(),
                'classrooms'   => ClassroomService::getAllClassrooms()->count(),
                'users'        => UserService::getAllUsers()->count(),
                'courses'      => CourseService::getAllCourses([2])->count(),
                'videoCourses' => VideoCourse::count()
            ];

            return view('home', compact('statistics', 'student', 'recent_courses', 'classrooms'));
        }

        if ($user->is_teacher)
        {
            $teacher_id = $user->id;

            $statistics['students'] = StudentService::countByTeacherId($teacher_id);
            $statistics['classrooms'] = ClassroomService::countByTeacherId($teacher_id);
            $statistics['courses'] = CourseService::countByTeacherId($teacher_id);

            return view('home', compact('statistics', 'student', 'recent_courses', 'classrooms'));
        }

        if ($user->studentsCount > 0)
        {
            if ($student != null)
            {
                $recent_courses = $student->recentCourses(10);
                $classrooms = $student->classrooms;
                $videoCourses = $student->videoCourses;

                AcessLog::create([
                    'user_id' => $user->id,
                    'student_id' => $student->id,
                    'role' => 'guardian',
                    'accessed_at' => now(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
                
            } else {
                return redirect()->route('students.chooseStudent');
            }
        }

        return view('home', compact('statistics', 'student', 'recent_courses', 'classrooms', 'videoCourses'));
    }
}

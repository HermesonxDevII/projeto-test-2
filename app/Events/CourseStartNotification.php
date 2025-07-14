<?php

namespace App\Events;

use App\Models\Course;
use App\Services\UserService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CourseStartNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;
    public $user;

    public function __construct(Course $course)
    {
        $this->course = $course;
        $this->user  = loggedUser();
    }

    public function broadcastOn()
    {
        // return ["channel-name-{$this->user}"];
        // return ["course-{$this->course->id}-notifications"];
        return ["course-notifications"];
        // return new PrivateChannel('channel-name');
        // return new PrivateChannel('course-notifications');
    }
}

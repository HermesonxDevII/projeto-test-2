<?php

use App\Services\StudentService;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('course-start', function () {
    return true;
});

// Broadcast::channel('course-notifications', function ($course) {
//     // return (int) auth()->user()->id != (int) $course->user_id;
//     return StudentService::getCoursesOfSelectedStudent()->contains($course->id);
// });
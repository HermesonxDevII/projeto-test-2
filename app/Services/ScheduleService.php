<?php

namespace App\Services;

use App\Models\{Schedule, Course};
use Illuminate\Database\Eloquent\Collection;

class ScheduleService
{
    static public function getAllSchedules(): Collection
    {
        return Schedule::all();
    }

    static public function getScheduleById(int $id)
    {
        return Schedule::findOrFail($id);
    }

    static public function storeSchedules(array $weekdays, int $course_id): void
    {
        foreach ($weekdays as $key => $value) {
            Schedule::create([
                "status" => $value['status'] == "on" ? 1 : 0,
                "course_id" => $course_id,
                "weekday_id" => $key
            ]);
        }
    }

    static public function deleteSchedules($schedules): void
    {
        Schedule::destroy($schedules);
    } 

    static public function updateSchedule(Schedule $schedule, string $status)
    {
        $schedule->update([
            "status" => $status == "on" ? 1 : 0
        ]);
    }
}

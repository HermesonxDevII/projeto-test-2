<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{Calendar, CalendarGrade};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Auth, DB};
use App\Http\Requests\CalendarRequest;

class CalendarService
{

    public static function storeCalendar(array $requestData): int
    {
        $calendar = Calendar::create($requestData);

        foreach($requestData['grade'] as $key => $value){
            CalendarGrade::create([
                "calendar_id" => $calendar->id,
                "grade_id" => $value["grade_id"]
            ]);
        }

        return $calendar->id;
    }

    public static function updateCalendar(CalendarRequest $request, Calendar $calendar): void
    {
        $calendar->update($request->input('calendar'));

        if ($request->filled('calendar.grade')){
            foreach($request["calendar"]["grade"] as $value){
                if(!empty($value["id"]) && !isset($value["grade_id"])){
                    CalendarGrade::findOrFail($value["id"])->delete();
                }
                if(empty($value["id"]) && isset($value["grade_id"])){
                    CalendarGrade::create([
                        "calendar_id" => $calendar->id,
                        "grade_id" => $value["grade_id"]
                    ]);
                }
            }
        }

    }

    public static function deleteCalendar(Calendar $calendar): void
    {
        foreach($calendar->grades as $grade){
            $grade->delete();
        }
        $calendar->delete();
    }

    public static function forceDeleteCalendar(Calendar $calendar): void
    {
        $calendar->forceDelete();
    }

    public static function restoreCalendar(Calendar $calendar): void
    {
        $calendar->restore();
    }

}

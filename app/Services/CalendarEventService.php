<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\CalendarEvent;

class CalendarEventService
{

    public static function store(array $data)
    {
        CalendarEvent::create($data);
    }
}

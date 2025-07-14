<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CalendarRequest;
use App\Http\Requests\CalendarEventRequest;
use App\Models\{Calendar, CalendarEvent, User, Grade};
use App\Services\{CalendarService, CalendarEventService, StudentService, ClassroomService};

class CalendarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Calendar::class);

        $calendars   = Calendar::all();
        return view('calendars.index', compact('calendars'));
    }

    public function newCalendar()
    {
        $this->authorize('viewAny', Calendar::class);

        $user = Auth::user();
        $role = $user->roles[0]->name;

        if ($role == 'admin' || $role == 'teacher') {

            if($role == 'admin') {
                $classrooms = ClassroomService::getAllClassrooms();
            } else {
                $classrooms = ClassroomService::getClassroomsByTeacherId($user->id, 1);
            }

            return view('calendars.newIndex', compact('classrooms'));
        } else {
            return view('calendars.newIndex');
        }
    }

    public function registerEvent(CalendarEventRequest $request)
    {
        $data = $request->validated();

        if ($data['repeat'] == 'never') {
            unset($data['stop_repetition']);
        }

        $isAllClassrooms = false;
        if ($data['classroom_id'] == 'all') {
            unset($data['classroom_id']);
            $data['all_classrooms'] = true;
            $isAllClassrooms = true;
        }

        DB::beginTransaction();

        try {
            CalendarEventService::store($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Evento criado com sucesso!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function updateEvent(CalendarEventRequest $request)
    {        
        $data = $request->validated();
        $eventId = $data['event_id'];
        $option = $data['option'];
        $eventDay = isset($data['event_day']) ? $data['event_day'] : null;

        if ($data['repeat'] == 'never') {
            unset($data['stop_repetition']);
        }

        $isAllClassrooms = false;
        if ($data['classroom_id'] == 'all') {
            unset($data['classroom_id']);
            $data['all_classrooms'] = true;
            $isAllClassrooms = true;
        }

        DB::beginTransaction();

        try {
            if ($option === 'all') {
                CalendarEvent::find($eventId)->update($data);
            } elseif ($option === 'single' && $eventDay) {
                $event = CalendarEvent::find($eventId);

                if ($event->repeat === 'never') {
                    // Evento já é único, só atualiza os dados
                    $event->start = $data['start'];
                    $event->end = $data['end'];
                    $event->name = $data['name'];
                    $event->color = $data['color'] ?? $event->color;
                    $event->days = $data['days'] ?? $event->days;
                    $event->save();
                } else {

                    $originalDays = explode(',', $event->days);
                    $originalDays = array_map('trim', $originalDays);

                    $remainingDays = array_filter($originalDays, function ($day) use ($eventDay) {
                        return trim($day) !== $eventDay;
                    });

                    $event->days = implode(', ', $remainingDays);
                    $event->save();

                    $newEvent = $event->replicate();
                    $newEvent->days = $eventDay;
                    $newEvent->start = $data['start'];
                    $newEvent->name = $data['name'];
                    $newEvent->end = $data['end'];
                    $newEvent->repeat = 'never';
                    $newEvent->stop_repetition = null;
                    $newEvent->save();
                
                }
                
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Evento atualizado com sucesso!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteEvent(Request $request)
    {
        $data = $request->all();
        $eventId = $data['event_id'];
        $option = $data['option'];
        $eventDay = isset($data['event_day']) ? $data['event_day'] : null;

        DB::beginTransaction();

        try {
            if ($option === 'all') {
                CalendarEvent::find($eventId)->delete();
            } elseif ($option === 'single' && $eventDay) {
                $event = CalendarEvent::find($eventId);

                $days = explode(',', $event->days);

                $days = array_map('trim', $days);

                $days = array_filter($days, function ($day) use ($eventDay) {
                    return $day !== $eventDay;
                });

                $event->days = implode(', ', $days);
                $event->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Evento excluído com sucesso!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getEvents($classroom, $month, $year)
    {
        try {
            $date = "{$month}/{$year}";

            $eventsQuery = CalendarEvent::select('id', 'name', 'color', 'start', 'end', 'days')
                ->where('months', 'LIKE', "%{$date}%");

            $user = Auth::user();
            $role = $user->roles[0]->name;

            if ($role === 'admin' && $classroom !== 'all') {
                $eventsQuery->where(function ($query) use ($classroom) {
                    $query->where('classroom_id', $classroom)
                        ->orWhere('all_classrooms', true);
                });
            } elseif ($role === 'guardian') {
                $student_id = session()->get('student_id');
                $classrooms_ids = StudentService::getStudentById($student_id)
                    ->classrooms->pluck('id');

                $eventsQuery->where(function ($query) use ($classrooms_ids) {
                    $query->whereIn('classroom_id', $classrooms_ids)
                        ->orWhere('all_classrooms', true);
                });
            } elseif ($role === 'teacher') {
                $teacher_classrooms = Classroom::whereHas('courses', function ($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                    $query->where('type', 1);
                })->isActive()->pluck('id');

                if($classroom == 'all') {
                    $eventsQuery->where(function ($query) use ($teacher_classrooms) {
                        $query->whereIn('classroom_id', $teacher_classrooms)
                            ->orWhere('all_classrooms', true);
                    });
                } else {
                    $eventsQuery->where(function ($query) use ($classroom) {
                        $query->where('classroom_id', $classroom)
                            ->orWhere('all_classrooms', true);
                    });
                }
                
            }

            $events = $eventsQuery->get();            

            return response()->json([
                'status' => 'success',
                'data' => $events
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }



    public function getEventById($event_id)
    {
        try {
            $event = CalendarEvent::find($event_id);

            return response()->json([
                'status' => 'success',
                'data' => $event
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function create(): View
    {
        $this->authorize('create', Calendar::class);
        $grades = Grade::all()->sortBy("name");
        $calendar = [];
        return view('calendars.create', compact('grades', 'calendar'));
    }

    public function store(CalendarRequest $request): RedirectResponse
    {

        $this->authorize('create', Calendar::class);
        DB::beginTransaction();

        try {
            $calendar_id = CalendarService::storeCalendar(
                $request->input('calendar')
            );

            DB::commit();
            notify('Calendário incluído com sucesso!');

            return redirect()->route('calendars.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível cadastrar o calendário solicitado.', 'error');
            return back();
        }
    }

    public function show(Calendar $calendar): View
    {
        $this->authorize('view', $calendar);
        $type = 'admin';
        return view('calendars.show', compact('calendar', 'type'));
    }

    public function edit(Calendar $calendar): View
    {
        $this->authorize('update', $calendar);
        $grades = Grade::all()->sortBy("name");
        return view('calendars.create', compact('grades', 'calendar'));
    }

    public function update(CalendarRequest $request, Calendar $calendar)
    {
        $this->authorize('update', $calendar);
        DB::beginTransaction();
        try {

            CalendarService::updateCalendar(
                $request,
                $calendar
            );

            DB::commit();
            notify('Calendário atualizado com sucesso!');

            return redirect()->route('calendars.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar o calendário solicitado.', 'error');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar): JsonResponse
    {
        $this->authorize('delete', Calendar::class);

        DB::beginTransaction();
        try {
            CalendarService::deleteCalendar($calendar);
            DB::commit();
            return response()->json([
                'icon' => 'success',
                'msg'  => 'Calendário excluído com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível excluir o calendário solicitado.'
            ], 500);
        }
    }

    public function student()
    {
        $student = selectedStudent();
        $calendars = StudentService::getGradeOfSelectedStudent($student);
        $this->authorize('view', $calendars ? $calendars->first() : null);
        $type = 'student';
        return view('calendars.show', compact('calendars', 'type', 'student'));
    }

    public function studentNewCalendar()
    {
        return view('calendars.newIndex');
    }

    public function calendarById($id)
    {
        try {
            $calendar = Calendar::findOrFail($id);

            return response()->json([
                'calendar' => $calendar
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Algo deu errado.'
            ], 500);
        }
    }
}

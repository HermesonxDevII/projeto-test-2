<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Http\Requests\{ StoreMeetingRequest };
use Illuminate\Support\Facades\{ Log, Http };

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        
    }

    public function create(Request $request)
    {
        
    }

    public function store(StoreMeetingRequest $request)
    {
        $validatedData = $request->validated();
        Log::info('validatedData', [$validatedData]);

        $token = getWherebyKey();
        Log::info('token', [$token]);

        $data = [
            'endDate'        => transmissionEndDate(),
            'isLocked'       => false,
            'roomMode'       => 'group',
            'roomNamePrefix' => generateSlug($validatedData['name']),
            'recording' => [
                'type' => 'local',
                'destination' => [
                    'provider'        => 'whereby',
                    'bucket'          => '',
                    'accessKeyId'     => '',
                    'accessKeySecret' => '',
                    'fileFormat'      => 'mp4'
                ],
                'startTrigger' => 'none'
            ],
            'fields' => [
                'hostRoomUrl',
                'viewerRoomUrl'
            ]
        ];
        Log::info('data', [$data]);

        $response = Http::withToken($token)
            ->post('https://api.whereby.dev/v1/meetings', $data);

        Log::info('response', [$response]);
        Log::info('response->json()', [$response->json()]);

        if ($response->failed()) {
            Log::info('erro');
            notify('Não foi possível criar a sala de transmissão. Tente novamente mais tarde.', 'error');
            return back();
        }

        $apiData = $response->json();

        $meeting = loggedUser()->meetings()->create([
            'name'            => $validatedData['name'],
            'description'     => $validatedData['description'],
            'start_date'      => formatBrazilDate($apiData['startDate']),
            'end_date'        => formatBrazilDate($apiData['endDate']),
            'room_name'       => $apiData['roomName'],
            'room_url'        => $apiData['roomUrl'],
            'host_room_url'   => $apiData['hostRoomUrl'],
            'viewer_room_url' => $apiData['viewerRoomUrl'],
            'meeting_id'      => $apiData['meetingId']
        ]);

        return redirect()->route('meetings.show', $meeting->id);
    }

    public function show(Request $request, Meeting $meeting)
    {
        if (!$meeting) {
            notify('Não foi possível encontrar a sala de transmissão.', 'error');
            return back();
        }

        $isHost = loggedUser()->id === $meeting->user_id;

        return view('meetings.show', compact('meeting', 'isHost'));
    }

    public function edit(Request $request)
    {
        
    }

    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        
    }
}

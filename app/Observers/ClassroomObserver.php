<?php

namespace App\Observers;

use App\Enums\ConversationType;
use App\Enums\ParticipantRole;
use App\Models\Classroom;
use App\Models\Conversation;
use App\Models\Group;
use Illuminate\Support\Facades\Log;

class ClassroomObserver
{
    /**
     * Handle the Classroom "created" event.
     */
    public function created(Classroom $classroom): void{}

    /**
     * Handle the Classroom "updated" event.
     */
    public function updated(Classroom $classroom): void
    {
        foreach ($classroom->wireGroups as $group) {
            $group->update([
                'name' => $classroom->name,
                'description' => $classroom->description,
            ]);
        }
    }

    /**
     * Handle the Classroom "deleted" event.
     */
    public function deleted(Classroom $classroom): void
    {
        $classroom = Group::where('classroom_id',$classroom->id)->first();
        
        if($classroom) {
            $conversation = Conversation::find($classroom->conversation_id);
            if($conversation) {
                $conversation->delete();
            }
        }
    }

    /**
     * Handle the Classroom "restored" event.
     */
    public function restored(Classroom $classroom): void
    {
        //
    }

    /**
     * Handle the Classroom "force deleted" event.
     */
    public function forceDeleted(Classroom $classroom): void
    {
        //
    }
}

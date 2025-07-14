<?php

namespace App\Models;

use App\Enums\ConversationType;
use App\Enums\ParticipantRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Namu\WireChat\Enums\Actions;

class Conversation extends Model
{
    use HasFactory;

    protected $table = "wire_conversations";

    protected $fillable = [
        'type',
        'disappearing_started_at',
        'disappearing_duration',
    ];

    protected $casts = [
        'type' => ConversationType::class,
        'updated_at' => 'datetime',
        'disappearing_started_at' => 'datetime',
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class, 'conversation_id', 'id');
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'conversation_id');
    }

    public function addParticipant(Model $user, ParticipantRole $role = ParticipantRole::PARTICIPANT, bool $undoAdminRemovalAction = false): Participant
    {
        // Check if the participant already exists (with or without global scopes)
        $participant = $this->participants()
            ->withoutGlobalScopes()
            ->where('participantable_id', $user->id)
            ->where('participantable_type', $user->getMorphClass())
            ->first();

        if ($participant) {
            // Abort if the participant exited themselves
            Log::info('Cannot add because they left the group.');

            // Check if the participant was removed by an admin or owner
            if ($participant->isRemovedByAdmin()) {
                // Abort if undoAdminRemovalAction is not true
                Log::info('Cannot add because they were removed from the group by an Admin.');

                // If undoAdminRemovalAction is true, remove admin removal actions and return the participant
                $participant->actions()
                    ->where('type', Actions::REMOVED_BY_ADMIN)
                    ->delete();

                return $participant;
            }

            // Abort if the participant is already in the group and has not exited
            Log::info('Participant is already in the conversation.');
        }

        // Validate participant limits for private or self conversations
        if ($this->isPrivate()) {
            Log::info('Private conversations cannot have more than two participants');
        }

        if ($this->isSelf()) {
            Log::info('Self conversations cannot have more than one participant.');
        }

        // Add a new participant
        return $this->participants()->create([
            'participantable_id' => $user->id,
            'participantable_type' => $user->getMorphClass(),
            'role' => $role,
        ]);
    }

    public function isPrivate(): bool
    {
        return $this->type == ConversationType::PRIVATE;
    }

    public function isSelf(): bool
    {
        return $this->type == ConversationType::SELF;
    }

}

<?php

namespace App\Models;

use App\Enums\ParticipantRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Namu\WireChat\Enums\Actions;

class Participant extends Model
{
    use HasFactory;

    protected $table = "wire_participants";

    protected $fillable = [
        'conversation_id',
        'participantable_id',
        'participantable_type',
        'role',
        'exited_at',
        'conversation_deleted_at',
        'conversation_cleared_at',
        'conversation_read_at',
        'last_active_at',
    ];

    protected $casts = [
        'role' => ParticipantRole::class,
        'exited_at' => 'datetime',
        'conversation_deleted_at' => 'datetime',
        'conversation_cleared_at' => 'datetime',
        'conversation_read_at' => 'datetime',
        'last_active_at' => 'datetime',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function isRemovedByAdmin(): bool
    {
        return $this->actions()
            ->where('type', Actions::REMOVED_BY_ADMIN->value)
            ->exists();
    }

    public function actions()
    {
        return $this->morphMany(Actions::class, 'actionable', 'actionable_type', 'actionable_id', 'id');
    }

    public function exitConversation(): bool
    {

        if (! $this->hasExited()) {
            $this->exited_at = now();

            return $this->save();
        }

        return false; // Already exited or conversation mismatch
    }

    public function hasExited(): bool
    {
        return $this->exited_at != null;
    }

}

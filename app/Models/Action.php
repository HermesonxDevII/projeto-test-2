<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Namu\WireChat\Enums\Actions;

class Action extends Model
{
    use HasFactory;

    protected $table = "wire_participants";

    protected $fillable = [
        'actor_id',
        'actor_type',
        'actionable_id',
        'actionable_type',
        'type',
        'data',
    ];

    protected $casts = [
        'type' => Actions::class,
    ];

    public function actionable()
    {
        return $this->morphTo(null, 'actionable_type', 'actionable_id', 'id');
    }

    // Polymorphic relationship to the actor (User, Admin, etc.)
    public function actor()
    {
        return $this->morphTo('actor', 'actor_type', 'actor_id', 'id');
    }

    // scope by Actor
    public function scopeWhereActor(Builder $query, Model $actor)
    {

        $query->where('actor_id', $actor->id)->where('actor_type', $actor->getMorphClass());

    }

    /**
     * Exclude participant passed as parameter
     */
    public function scopeWithoutActor($query, Model $user): Builder
    {

        return $query->where(function ($query) use ($user) {
            $query->where('actor_id', '<>', $user->id)
                ->orWhere('actor_type', '<>', $user->getMorphClass());
        });

        //  return $query->where(function ($query) use ($user) {
        //      $query->whereNot('participantable_id', $user->id)
        //            ->orWhereNot('participantable_type', $user->getMorphClass());
        //  });
    }
}

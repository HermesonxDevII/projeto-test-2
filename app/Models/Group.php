<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = "wire_groups";

    protected $fillable = [
        'conversation_id',
        'name',
        'description',
        'classroom_id'
    ];

    protected $casts = [
        'allow_members_to_send_messages' => 'boolean',
        'allow_members_to_add_others' => 'boolean',
        'allow_members_to_edit_group_info' => 'boolean',

    ];

    public function classroom()
    {
        return $this->belongsTo(\App\Models\Classroom::class);
    }

}

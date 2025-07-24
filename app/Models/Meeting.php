<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\{ BelongsTo };
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Meeting extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'meetings';
    protected $primaryKey = 'id';

    protected $fillable = [

    ];

    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::Class);
    }

    public function startDate(): Attribute
    {
        return Attribute::make(
            fn (string $value) => Carbon::make($value)->subHours(3)->format('d/m/Y H:i')
        );
    }

    public function endDate(): Attribute
    {
        return Attribute::make(
            fn (string $value) => Carbon::make($value)->subHours(3)->format('d/m/Y H:i')
        );
    }
}

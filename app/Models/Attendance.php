<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['user_id', 'date', 'time_in', 'time_out'];

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $casts = [
        'date' => 'date:Y-m-d',
        'time_in' => 'date:H:i',
        'time_out' => 'date:H:i'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

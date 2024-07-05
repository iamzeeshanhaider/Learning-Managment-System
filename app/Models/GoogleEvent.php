<?php

namespace App\Models;

use Google\Service\Calendar\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;

class GoogleEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'user_id', 'attendee_id', 'has_meeting_link', 'reference'
    ];

    protected $casts = [
        'has_meeting_link' => 'boolean',
        'start_time' => 'datetime:m-d-Y',
        'end_time' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getMetaData()
    {
        return $this->reference ? GoogleCalendarEvent::find($this->reference) : null;
    }

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'attendee_id');
    }

}

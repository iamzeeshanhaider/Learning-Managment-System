<?php

namespace App\Models;

use App\Notifications\EventCreatedNotification;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventNotification extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['event_id', 'user_id', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }

    public function sendNotification()
    {
        $this->user->notify(new EventCreatedNotification($this->event));
    }

}

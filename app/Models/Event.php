<?php

namespace App\Models;

use App\Enums\EventGroup;
use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory, LogsActivity, Slugable;

    protected $fillable = ['title', 'slug', 'content', 'date', 'status', 'image', 'group', 'created_by', 'notify_group'];

    protected $casts = [
        'status' => GeneralStatus::class,
        'group' => EventGroup::class,
        'date' => 'datetime',
        'notify_group' => 'boolean'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function batch(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'event_group_batches', 'event_id')->withTimestamps();
    }

    public function eventNotifications(): HasMany
    {
        return $this->hasMany(EventNotification::class);
    }

    public function getUsersForNotification()
    {
        switch ($this->group) {
            case EventGroup::Admin:
                return User::admin()->get();

            case EventGroup::Instructors:
                return User::instructor()->get();

            case EventGroup::Students:
                return User::student()->get();

            case EventGroup::ByBatch:
                if ($this->batch) {
                    $userIds = $this->batch->pluck('students')->flatten()->pluck('id')->toArray();
                    return User::whereIn('id', $userIds)->get();
                }
                break;

            case EventGroup::AllUsers:
            default:
                return User::all();
        }
    }

    public function getTotalReadEventNotifications()
    {
        return $this->eventNotifications()->where('is_read', true)->count();
    }

    public function scopePublished()
    {
        return Event::where('status', GeneralStatus::Enabled);
    }

    public function setBannerAttribute($value)
    {
        $this->attributes['banner'] = storeImage($this->banner, $value, \constPath::EventImage);
    }

    public function getStatusNameAttribute()
    {
        return [
            'Enabled' => 'Published',
            'Disabled' => 'Draft',
        ][$this->status] ?? 'Draft';
    }
}

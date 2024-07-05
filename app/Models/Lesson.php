<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use VanOns\Laraberg\Traits\RendersContent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory, RendersContent, Slugable, LogsActivity;

    protected  $fillable = ['name', 'outcome', 'course_id', 'status', 'image', 'slug'];

    protected $casts = [
        'status' => GeneralStatus::class
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(LessonResource::class);
    }

    public function folders(): HasMany
    {
        return $this->hasMany(LessonFolder::class, 'lesson_id');
    }

    public function content()
    {
        return $this->larabergContent();
    }

    public function messages()
    {
        return $this->morphMany('App\Models\Message', 'messageable')->with('user');
    }

    public function getStatusColorAttribute()
    {
        return [
            'Enabled' => 'primary',
            'Disabled' => 'secondary',
            'Ongoing' => 'warning',
            'Cancelled' => 'danger',
            'Completed' => 'success',
        ][$this->status] ?? 'primary';
    }

    public function getTypeColorAttribute()
    {
        return [
            'video' => 'primary',
            'slide' => 'warning',
            'document' => 'success',
        ][$this->type] ?? 'primary';
    }
}

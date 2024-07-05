<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected  $fillable = [
        'title', 'slug', 'description', 'start_time', 'end_time', 'obtainable_points',
        'attempts', 'duration', 'course_id', 'created_by', 'status', 'batch_id', 'is_average'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => GeneralStatus::class,
        'is_average' => 'boolean'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function getFormatDurationAttribute()
    {
        $durationInMinutes = $this->duration / 60;

        if ($durationInMinutes >= 60) {
            $duration = floor($durationInMinutes / 60) . ' hours';
        } else {
            $duration = $durationInMinutes . ' minutes';
        }

        return $duration;
    }


    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class)->where('batch_id', getActiveBatch()->id);
    }

    public function scopeForBatch($query, $batchId)
    {
        return $query
            ->whereHas('questions')
            ->where(['status' => GeneralStatus::Enabled, 'batch_id' => $batchId]);
    }

    public function submissionsCount()
    {
        return $this->submissions()->groupBy('student_id')->distinct('quiz_id')->count();
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function getStatusColorAttribute()
    {
        return [
            'Enabled' => 'primary',
            'Disabled' => 'secondary',
        ][$this->status] ?? 'primary';
    }

    public function getStatusNameAttribute()
    {
        return [
            'Enabled' => 'Published',
            'Disabled' => 'Un-Published',
        ][$this->status] ?? 'Un-Published';
    }
}

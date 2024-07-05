<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Course extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $fillable = ['title', 'code', 'slug', 'status', 'image', 'price', 'start_date', 'end_date', 'location_id', 'instructor_id', 'course_master_id', 'module_id'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => GeneralStatus::class
    ];

    public function scopeFrontEndCourse()
    {
        return $this->where('status', GeneralStatus::Enabled())->with('instructor:id,name,image,slug', 'students:id');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }

    public function course_master(): BelongsTo
    {
        return $this->belongsTo(CourseMaster::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'batch_users', 'course_id', 'student_id')
            ->withPivot('id', 'batch_id', 'payment_id')
            ->withTimestamps();
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'batch_users', 'course_id', 'batch_id', 'student_id')
            ->withPivot('id', 'batch_id', 'payment_id')
            ->withTimestamps();
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_users', 'course_id', 'student_id', 'batch_id');
    }

    public function getBatch()
    {
        return Batch::find($this->pivot->batch_id);
    }

    public function getPaymentLog()
    {
        return Payment::where(['course_id' => $this->id, 'batch_id' => $this->pivot->batch_id, 'student_id' => $this->pivot->student_id])->get();
    }

    public function getCourseUser() // TODO: refactor this
    {
        return BatchUser::where(['student_id' => auth()->user()->id, 'course_id' => $this->id])->first();
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->where(['status' => GeneralStatus::Enabled]);
    }

    public function resources(): HasManyThrough
    {
        return $this->hasManyThrough(LessonResource::class, Lesson::class);
    }

    public function quizzes($batchId = null): HasMany
    {
        $batchId = $batchId ?? getActiveBatch()->id;

        return $this->hasMany(Quiz::class)
            ->whereHas('questions')
            ->where(['status' => GeneralStatus::Enabled, 'batch_id' => $batchId]);
    }

    public function quizCount(): int
    {
        return $this->hasMany(Quiz::class)->count();
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable')->with('user');
    }

    public function price()
    {
        return $this->price == 0 || $this->price == Null ? 'Free' : Config::get('settings.symbol') . $this->price;
    }

    public function duration()
    {
        if ($this->start_date && $this->end_date) {
            // Calculate the duration between the two dates:
            $duration = $this->start_date->diff($this->end_date);

            // Get the duration in days:
            $days = $duration->days;

            return $days . 'Day(s)';
        }
        return '∞ Day(s)';
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

    public function scopeSearch(Builder $builder, Collection $data)
    {
        if ($data->has('search')) {
            $search = $data->get('search');
            $builder
                ->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('code', 'LIKE', '%' . $search . '%');
            // ->orWhereHas('course_master', function ($q) use ($search) {
            //     $q->where('name', 'LIKE', '%' . $search . '%');
            // });
        }
    }
}

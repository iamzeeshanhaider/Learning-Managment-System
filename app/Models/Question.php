<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected  $fillable = [
        'question', 'slug', 'instruction', 'quiz_id', 'status'
    ];

    protected $casts = [
        'status' => GeneralStatus::class,
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'question_id');
    }
}

<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory, LogsActivity;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'quiz_id', 'batch_id', 'score', 'feedback'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function batch_info(): BelongsTo
    {
        return BatchUser::find($this->batch->id);
    }

    public function data(): HasMany
    {
        return $this->hasMany(SubmissionData::class);
    }

    public function file()
    {
        return asset(!empty($this->file) ? \constPath::SubmissionFile . '/' . $this->file : '');
    }
}

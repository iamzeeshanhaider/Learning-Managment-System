<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BatchUser extends Model
{
    use LogsActivity;

    protected $table = 'batch_users';

    protected $fillable = [
        'status', 'student_id', 'course_id', 'batch_id', 'payment_id', 'completed_resources',
        'fee', 'discount', 'fee_after_discount', 'next_payment_due_date', 'submitted_quiz', 'hidden_resources'
    ];

    protected $casts = [
        'status' => GeneralStatus::class,
        'completed_resources' => 'array',
        'hidden_resources' => 'array',
        'submitted_quiz' => 'array',
        'next_payment_due_date' => 'date'
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'batch_user_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function getTotalPayments()
    {
        return $this->payment->amount_paid + $this->payment->children->sum('amount_paid');
    }

    public function getBalance()
    {
        $total_paid =  $this->payment->amount_paid + $this->payment->children->sum('amount_paid');

        return ($this->fee_after_discount ?? $this->fee) - $total_paid;
    }

}

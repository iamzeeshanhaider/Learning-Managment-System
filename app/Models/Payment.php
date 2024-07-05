<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $fillable = [
        'student_id', 'status', 'parent_id',
        'amount_paid', 'proof_of_payment', 'invoice_id', 'payment_mode',
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $casts = [
        'status' => GeneralStatus::class
    ];

    /**
     * The student that owns this payment
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'batch_users', 'course_id', 'payment_id');
    }

    public function batch(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'batch_users', 'batch_id', 'payment_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id')->where('parent_id', '!=', null);
    }

}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\GeneralStatus;

class Chat extends Model
{
    use HasFactory, Slugable;

    protected $fillable = [
        'slug',
        'status',
        'issue',
        'assigned_to_id',
        'created_by_id',
        'updated_by_id',
    ];


    protected $casts = [
        'status' => GeneralStatus::class
    ];

    public function conversation()
    {
        return $this->hasMany(ChatConversation::class);
    }
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function assigned_to(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id', 'id');
    }



}

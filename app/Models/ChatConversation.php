<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\GeneralStatus;

class ChatConversation extends Model
{
    use HasFactory, Slugable;

    protected $fillable = [
        'name',
        'slug',
        'chat_layer_id',
        'chat_question_id',
        'chat_option_id',
        'chat_id',
        'status',
        'created_by_id',
        'updated_by_id',
    ];


    protected $casts = [
        'status' => GeneralStatus::class
    ];

    public function layer(): BelongsTo
    {
        return $this->belongsTo(ChatLayer::class, 'chat_layer_id');
    }


    public function question(): BelongsTo
    {
        return $this->belongsTo(ChatQuestion::class, 'chat_question_id');
    }


    public function option(): BelongsTo
    {
        return $this->belongsTo(ChatOption::class, 'chat_option_id');
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }


    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

}

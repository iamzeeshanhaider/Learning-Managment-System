<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TicketComment extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['ticket_id', 'user_id', 'comment'];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class,  'ticket_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attachment(): HasOne
    {
        return $this->hasOne(CommentAttachement::class, 'comment_id');
    }
}

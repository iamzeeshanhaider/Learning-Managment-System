<?php

namespace App\Models;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentAttachement extends Model
{
    use HasFactory;

    protected $fillable = ['comment_id', 'image'];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(TicketComment::class,  'comment_id');
    }
}

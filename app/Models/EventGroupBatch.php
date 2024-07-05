<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventGroupBatch extends Model
{
    use HasFactory;

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'event_group_batches', 'batch_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_group_batches', 'event_id');
    }
}

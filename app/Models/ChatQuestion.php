<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatQuestion extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $fillable = [
        'question',
        'slug',
        'created_by_id',
        'updated_by_id',
    ];

    public function options()
    {
        return $this->hasMany(ChatOption::class);
    }

    public function chatLayer()
    {
        return $this->belongsTo(ChatLayer::class, 'layer_id'); // Update to use 'layer_id' as foreign key column
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

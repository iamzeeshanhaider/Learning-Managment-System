<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatLayer extends Model
{
    use Slugable, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'created_by_id',
        'updated_by_id',
    ];
    public function questions()
    {
        return $this->hasMany(ChatQuestion::class);
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

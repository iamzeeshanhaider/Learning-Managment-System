<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Traits\Slugable;

class Message extends Model
{

    use Slugable, LogsActivity;
    
    protected $fillable = ['message', 'user_id'];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messageable() : MorphTo
    {
        return $this->morphTo();
    }
}

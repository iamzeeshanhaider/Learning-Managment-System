<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ChatOption extends Model
{
    use HasFactory, Slugable;

    protected $fillable = [
        'option',
        'slug',
        'created_by_id',
        'updated_by_id',
    ];



    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

}

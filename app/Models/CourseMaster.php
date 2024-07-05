<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseMaster extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $fillable = ['name', 'slug', 'description', 'category_id', 'status'];

    protected $casts = [
        'status' => GeneralStatus::class
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

}

<?php

namespace App\Models;

use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $fillable = ['name', 'description', 'slug', 'image'];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}

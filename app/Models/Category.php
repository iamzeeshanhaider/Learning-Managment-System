<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $fillable = ['name', 'description', 'slug', 'status', 'image'];

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $casts = [
        'status' => GeneralStatus::class
    ];

    public function courses_master(): HasMany
    {
        return $this->hasMany(CourseMaster::class);
    }

    public function singleCategoryLink()
    {
        return Route('categories.show', $this->slug);
    }
}

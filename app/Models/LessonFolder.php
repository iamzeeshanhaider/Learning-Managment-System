<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class LessonFolder extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = ['name', 'lesson_id', 'is_published', 'slug'];

    protected $casts = [
        'is_published' => 'boolean'
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(LessonResource::class, 'folder_id');
    }

    public function setNameAttribute($value)
    {
        // Check if the name already exists in the database
        $originalValue = $value;
        $counter = 2;
        while ($this->nameExists($value)) {
            $value = "$originalValue ($counter)";
            $counter++;
        }

        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value . substr(str_shuffle(sha1(now())), 0, 4));
    }

    protected function nameExists($name)
    {
        // Check if any other post with the same slug already exists in the database
        return static::where('name', $name)->exists();
    }

    public function scopeSearch(Builder $query, Collection $data)
    {
        if ($data->has('search')) {
            $search = $data->get('search');
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        if ($data->has('published')) {
            $query->isPublished($data->get('published'));
        }
    }

    public function scopeIsPublished(Builder $query, $published)
    {
        $query->where('is_published', $published);
    }

}

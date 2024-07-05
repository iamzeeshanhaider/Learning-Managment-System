<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Batch extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $fillable = ['name', 'description', 'slug', 'status'];

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $casts = [
        'status' => GeneralStatus::class
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'batch_users', 'batch_id', 'student_id')->withPivot('student_id')->withTimestamps();
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'batch_users', 'course_id', 'batch_id');
    }

    public function broadcast()
    {
        return $this->hasMany(BroadcastMessages::class);
    }

    public function scopeSearch(Builder $builder, $data)
    {
        if ($data->has('search')) {
            $search = $data->get('search');
            $builder->where('name', 'like', '%' . $search . '%');
        }
    }

}

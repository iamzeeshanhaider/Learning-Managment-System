<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Enums\LocationTypes;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $fillable = ['name', 'description', 'status', 'slug', 'seat_capacity', 'remaining_seat', 'type'];

    protected $casts = [
        'status' => GeneralStatus::class,
        'type' => LocationTypes::class
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function getTypeColorAttribute()
    {
        $color = 'primary';
        switch ($this->type) {
            case LocationTypes::Online;
                $color = 'primary';
                break;
            case LocationTypes::Physical;
                $color = 'success';
                break;
        }
        return $color;
    }

}

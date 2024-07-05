<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Slugable;

class CourseOrder extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $guarded = [];
}

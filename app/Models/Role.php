<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Slugable;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, LogsActivity;
}

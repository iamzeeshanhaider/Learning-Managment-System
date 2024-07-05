<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    /**
     * @var string
     */
    protected $table = 'activity_logs';


    /**
     * @var string[]
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'user_id',
        'guard_name',
        'module_name',
        'action',
        'old_value',
        'new_value',
        'ip_address'
    ];

    // protected $casts = [
    //     'old_value' => 'json',
    //     'new_value' => 'json'
    // ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}



<?php

namespace App\Models;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory, Slugable;

    protected $fillable = [
        'user_id',
        'course_id',
        'is_revoked',
        'downloads',
        'name',
        'path',
    ];

    protected $cast = [
        'is_revoked' => 'boolean'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function revoke_cert()
    {
        $this->update(['is_revoked' => !$this->is_revoked]);
    }

    public function downloaded()
    {
        $this->increment('downloads');
    }
}

<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonResource extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected  $fillable = ['name', 'file', 'url', 'slug', 'type', 'embed_code', 'lesson_id', 'status', 'folder_id'];

    protected $contentColumn = 'file';

    protected $casts = [
        'status' => GeneralStatus::class
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(LessonFolder::class, 'folder_id');
    }

    public function getStatusColorAttribute()
    {
        return [
            'Enabled' => 'primary',
            'Ongoing' => 'warning',
            'Cancelled' => 'danger',
            'Completed' => 'success',
        ][$this->status] ?? 'primary';
    }

    public function getTypeColorAttribute()
    {
        switch ($this->type) {
            case 'file':
                return [
                    'mp4' => 'primary',
                    'webm' => 'primary',
                    'mkv' => 'primary',
                    '3gp' => 'primary',
                    'pptx' => 'warning',
                    'docx' => 'info',
                    'pdf' => 'warning',
                ][$this->extention] ?? 'primary'; // jpg, jpeg, gif, png, tiff
                break;

            case 'url':
                return 'info';
                break;

            case 'embed':
                return 'success';
                break;

            default:
                return 'primary';
                break;
        }
    }

    public function getTypeIconAttribute()
    {
        switch ($this->type) {
            case 'file':
                return [
                    'mp4' => 'video-camera',
                    'webm' => 'video-camera',
                    'mkv' => 'video-camera',
                    '3gp' => 'video-camera',
                    'pptx' => 'file-powerpoint-o',
                    'pdf' => 'file-pdf-o',
                    'docx' => 'file',
                    'jpg' => 'image',
                    'jpeg' => 'image',
                    'gif' => 'image',
                    'png' => 'image',
                    'tiff' => 'image',
                    'zip' => 'file-archive-o',
                ][$this->extention] ?? 'file';
                break;

            case 'url':
                return 'link';
                break;

            case 'embed':
                return 'code';
                break;

            default:
                return 'link';
                break;
        }
    }
}

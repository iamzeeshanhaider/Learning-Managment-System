<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    public static function defaultPermissions()
    {
        return [
            'manage_categories',
            'manage_modules',
            'manage_locations',
            'manage_courses_masters',
            'manage_courses',
            'manage_lessons',
            'manage_batches',

            'manage_admin',
            'manage_students',
            'manage_instructors',
            'manage_events',

            'manage_ticket_categories',
            'manage_support_tickets',
            'manage_chat_layers',

            'manage_chat_requests',
            'manage_chat',
            'view_attendances',
            'view_activity_logs',
            'manage_settings'
        ];
    }
}

<?php

namespace App\Models;

use App\Traits\LogsActivity;
use App\Traits\Slugable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 *
 * @property string $name
 * @property string media_token
 * @property string email
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasApiTokens, HasRoles, HasFactory, Slugable, LogsActivity;

    protected $appends = ['avatar'];
    protected $dobFormat = 'Y-m-d';

    // groups = student, instructor, admin, default

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lname', 'email', 'phone', 'username',
        'status', 'password', 'image', 'code', 'slug',
        'gender', 'dob', 'country_id', 'city', 'address',
        'designation', 'last_login', 'last_login_ip_address', 'calendar_id',
        'email_verified_at', 'media_token', 'ethnicity', 'has_completed_profile', 'uk_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'dob' => 'date:Y-m-d',
        'has_completed_profile' => 'boolean',
    ];

    public function dob()
    {
        return $this->dob ? $this->dob->format('Y-m-d') : '';
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function getAvatarAttribute()
    {
        return $this->image ? $this->image() : Gravatar::get($this->attributes['email']);
    }

    public function userCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'instructor_id', 'id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'batch_users', 'student_id', 'course_id')
            ->withPivot('id', 'student_id', 'course_id', 'batch_id')
            ->withTimestamps();
    }

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'batch_users', 'student_id', 'batch_id')->withTimestamps();
    }

    public function studentBatchMeta(): HasMany
    {
        return $this->hasMany(BatchUser::class, 'student_id', 'id');
    }

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'batch_users', 'student_id', 'payment_id')->withTimestamps();
    }

    public function assignRoles()
    {
        foreach ($this->getRoleNames() as $role) {
            return $role;
        }
    }

    public function bio(): HasOne // retrives student information
    {
        return $this->hasOne(StudentInfo::class);
    }

    public function singleInstrutorLink()
    {
        return Route('users.show', ['group' => 'instructor', 'user' => $this->slug]);
    }

    public function scopeStudent()
    {
        return User::Role('student');
    }

    public function scopeInstructor()
    {
        return User::Role('instructor');
    }

    public function scopeAdmin()
    {
        return User::Role('admin');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function isAdmin()
    {
        return in_array('Admin', $this->getRoleNames()->toArray());
    }

    public function isInstructor()
    {
        return in_array('Instructor', $this->getRoleNames()->toArray());
    }

    public function isStudent()
    {
        return in_array('Student', $this->getRoleNames()->toArray());
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'student_id')->where('batch_id', getActiveBatch()->id);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function eventNotifications(): HasMany
    {
        return $this->hasMany(EventNotification::class);
    }

    public function unreadEventNotifications()
    {
        return $this->eventNotifications()->where('is_read', 0);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // TODO:
    // All unread event notifications
    // mark single event notifications as read
    // mark all evnets notifications as read
    // option to notify user group immediately, while creting event

}

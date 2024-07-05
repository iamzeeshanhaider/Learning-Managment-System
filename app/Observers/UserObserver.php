<?php

namespace App\Observers;

use App\Models\StudentInfo;
use App\Models\User;
use App\Notifications\AccountCreation;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user): void
    {
        // if($user->wasRecentlyCreated) {
        // Sample Default Password JI_secured_23
        $default_password = $user->name[0] . $user->lname[0] . '_secured_' . date('y');

        // Set Default Password for new user - this is sent to the user via email
        $user->update([
            'password' => Hash::make($default_password),
            'username' => $user->username ?? ($user->name[0] . $user->lname . rand(1, 100000)),
        ]);

        // Generate student id if necessary
        if ($user->hasRole('Student') && !$user->bio) {
            StudentInfo::updateOrCreate(
                ['user_id' => $user->id],
                ['student_id' => $this->generateInitials($user->name, $user->lname)]
            );
        }

        // Send Mail
        $user->notify(new AccountCreation([
            'lname' => $user->lname,
            'email' => $user->email,
            'default_password' => $default_password,
        ]));
        // }

    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        // Generate student id if necessary
        if ($user->hasRole('Student') && !$user->bio) {
            StudentInfo::updateOrCreate(
                ['user_id' => $user->id],
                ['student_id' => $this->generateInitials($user->name, $user->lname)]
            );
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        // Unenroll from course

        // delete student record
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }

    /**
     * Generate initials from a name
     *
     * @param string $name
     * @return string
     */
    public function generateInitials(string $first_name, string $last_name): string
    {
        $inital = 'ST' . date('Ymd') . "|" . date("his") . '-' . $first_name[0] . $last_name[0] . date('m');
        return $inital;
    }
}

<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class EventGroup extends Enum
{
    const AllUsers = 'All Users';
    const Admin = 'Admin';
    const Students = 'Students';
    const Instructors = 'Instructor';
    const ByBatch = 'By Batch';
}

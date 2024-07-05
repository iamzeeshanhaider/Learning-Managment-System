<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Enabled()
 * @method static static Disabled()
 * @method static static Ongoing()
 * @method static static Cancelled()
 * @method static static Completed()
 */
final class GeneralStatus extends Enum
{
    const Enabled = 'Enabled';
    const Disabled = 'Disabled';
    const Ongoing = 'Ongoing';
    const Cancelled = 'Cancelled';
    const Completed = 'Completed';
}

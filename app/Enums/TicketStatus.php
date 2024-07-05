<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Open()
 * @method static static Closed()
 * @method static static resolved()
 */
final class StudentBadge extends Enum
{
    const Open = "open";
    const Closed = "closed";
    const resolved = "resolved";


}

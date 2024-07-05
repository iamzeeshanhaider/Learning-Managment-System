<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Physical()
 * @method static static Online()
 */
final class LocationTypes extends Enum
{
    const Physical = 'physical';
    const Online = 'online';
}

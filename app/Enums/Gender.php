<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Male()
 * @method static static Female()
 * @method static static Others()
 */
final class Gender extends Enum
{
    const Male = 'male';
    const Female = 'female';
    const Others = 'others';
}

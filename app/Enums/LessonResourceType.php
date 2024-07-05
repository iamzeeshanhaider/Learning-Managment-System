<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static file()
 * @method static static url()
 * @method static static embed()
 */
final class LessonResourceType extends Enum
{
    const File = 'file';
    const URL = 'url';
    const Embed = 'embed';
}

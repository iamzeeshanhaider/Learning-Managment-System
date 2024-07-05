<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Text()
 * @method static static Boolean()
 * @method static static FileUpload()
 */
final class QuizTypes extends Enum
{
    const Text = 'Text';
    // const Boolean = 'True or False';
    const FileUpload = 'File Upload';
}

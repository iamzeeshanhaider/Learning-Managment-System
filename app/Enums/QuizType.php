<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static FileUpload()
 * @method static static OptioTextnTwo()
 * @method static static Boolean()
 * @method static static MultipleOptions()
 */
final class QuizType extends Enum
{
    const FileUpload = 'File Upload';
    const Text = 'Text';
    const MultipleOptions = 'Multiple Options';
}

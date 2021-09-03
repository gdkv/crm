<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class FamilyStatus extends ReadableEnum
{

    public const MARRIED = 'married';
    public const WIDOW = 'widow';
    public const DIVORCED = 'divorced';
    public const SINGLE = 'single';

    public static function values(): array
    {
        return [
            self::MARRIED,
            self::WIDOW,
            self::DIVORCED,
            self::SINGLE,
        ];
    }

    public static function readables(): array
    {
        return [
            self::MARRIED => 'Женат / Замужем',
            self::WIDOW => 'Вдовец / Вдова',
            self::DIVORCED => 'Разведен / Разведена',
            self::SINGLE => 'Неженат / Незамужем',
        ];
    }
}
<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class Gender extends ReadableEnum
{
    public const MALE = 'MALE';
    public const FEMALE = 'FEMALE';

    public static function values(): array
    {
        return [
            self::MALE,
            self::FEMALE,
        ];
    }

    public static function readables(): array
    {
        return [
            self::MALE => 'Мужской',
            self::FEMALE => 'Женский',
        ];
    }
}
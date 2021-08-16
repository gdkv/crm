<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class Status extends ReadableEnum
{
    public const WORK = 'WORK';
    public const FIRED = 'FIRED';
    public const SEAK = 'SEAK';
    public const HOLIDAY = 'HOLIDAY';

    public static function values(): array
    {
        return [
            self::WORK,
            self::FIRED,
            self::SEAK,
            self::HOLIDAY,
        ];
    }

    public static function readables(): array
    {
        return [
            self::WORK => 'Работает',
            self::FIRED => 'Уволен',
            self::SEAK => 'Больничный',
            self::HOLIDAY => 'Отпуск',
        ];
    }
}
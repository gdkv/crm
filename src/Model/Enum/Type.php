<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class Type extends ReadableEnum
{
    public const CALL = 'CALL';
    public const SITE = 'SITE';
    public const MANUAL = 'MANUAL';

    public static function values(): array
    {
        return [
            self::CALL,
            self::SITE,
            self::MANUAL,
        ];
    }

    public static function readables(): array
    {
        return [
            self::CALL => 'Звонок',
            self::SITE => 'Сайт',
            self::MANUAL => 'Ручная',
        ];
    }
}
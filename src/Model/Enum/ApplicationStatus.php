<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class ApplicationStatus extends ReadableEnum
{
    public const CALL = 'CALL';
    public const MEETING = 'MEETING';
    public const ARRIVED = 'ARRIVED';
    public const ARCHIVED = 'ARCHIVED';

    public static function values(): array
    {
        return [
            self::CALL,
            self::MEETING,
            self::ARRIVED,
            self::ARCHIVED,
        ];
    }

    public static function readables(): array
    {
        return [
            self::CALL => 'Звонок',
            self::MEETING => 'Встреча',
            self::ARRIVED => 'Приехал (в салоне)',
            self::ARCHIVED => 'Архив',
        ];
    }
}
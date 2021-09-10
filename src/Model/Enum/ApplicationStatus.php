<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class ApplicationStatus extends ReadableEnum
{
    public const CALL = 'CALL';
    public const MEETING = 'MEETING';
    public const ARRIVED = 'ARRIVED';
    public const ARCHIVED = 'ARCHIVED';
    public const IMPORTANT = 'IMPORTANT';
    public const CREDIT = 'CREDIT';

    public static function values(): array
    {
        return [
            self::CALL,
            self::MEETING,
            self::ARRIVED,
            self::ARCHIVED,
            self::IMPORTANT,
            self::CREDIT,
        ];
    }

    public static function readables(): array
    {
        return [
            self::CALL => 'Звонок',
            self::MEETING => 'Встреча',
            self::ARRIVED => 'Приехал (в салоне)',
            self::ARCHIVED => 'Архив',
            self::IMPORTANT => 'Важная',
            self::CREDIT => 'Кредит',
        ];
    }
}
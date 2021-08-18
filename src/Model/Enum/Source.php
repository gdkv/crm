<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class Source extends ReadableEnum
{
    public const STREET = 'CALL';
    public const FRIEND = 'FRIEND';
    public const SITE = 'SITE';
    public const BOUGHT = 'BOUGHT';
    public const CHAT = 'CHAT';
    public const EMPLOYEE = 'EMPLOYEE';
    public const MASMOTORS = 'MASMOTORS';
    public const PREVIOUSLY = 'PREVIOUSLY';
    public const MISSED = 'MISSED';
    public const CALL = 'CALL';
    public const OTHER = 'OTHER';

    public static function values(): array
    {
        return [
            self::STREET,
            self::FRIEND,
            self::SITE,
            self::BOUGHT,
            self::CHAT,
            self::EMPLOYEE,
            self::MASMOTORS,
            self::PREVIOUSLY,
            self::MISSED,
            self::CALL,
            self::OTHER,
        ];
    }

    public static function readables(): array
    {
        return [
            self::STREET => '',
            self::FRIEND => '',
            self::SITE => '',
            self::BOUGHT => '',
            self::CHAT => '',
            self::EMPLOYEE => '',
            self::MASMOTORS => '',
            self::PREVIOUSLY => '',
            self::MISSED => '',
            self::CALL => '',
            self::OTHER => '',
        ];
    }
}
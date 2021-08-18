<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class Reason extends ReadableEnum
{
    public const NOTGOTOMOSCOW = 'NOTGOTOMOSCOW';
    public const NOTOFFICIAL = 'NOTOFFICIAL';
    public const EXPENSIVE = 'EXPENSIVE';
    public const DOUBLES = 'DOUBLES';
    public const NOTPURCHASE = 'NOTPURCHASE';
    public const ANOTHERDEALER = 'ANOTHERDEALER';
    public const NOTANSWER = 'NOTANSWER';
    public const NOTRELEVANT = 'NOTRELEVANT';
    public const REVIEWS = 'REVIEWS';
    public const NOTCREDIT = 'NOTCREDIT';
    public const WRONGNUMBER = 'WRONGNUMBER';
    public const MAINTENANCE = 'MAINTENANCE';
    public const LTD = 'LTD';

    public static function values(): array
    {
        return [
            self::NOTGOTOMOSCOW,
            self::NOTOFFICIAL,
            self::EXPENSIVE,
            self::DOUBLES,
            self::NOTPURCHASE,
            self::ANOTHERDEALER,
            self::NOTANSWER,
            self::NOTRELEVANT,
            self::REVIEWS,
            self::NOTCREDIT,
            self::WRONGNUMBER,
            self::MAINTENANCE,
            self::LTD,
        ];
    }

    public static function readables(): array
    {
        return [
            self::NOTGOTOMOSCOW => '',
            self::NOTOFFICIAL => '',
            self::EXPENSIVE => '',
            self::DOUBLES => '',
            self::NOTPURCHASE => '',
            self::ANOTHERDEALER => '',
            self::NOTANSWER => '',
            self::NOTRELEVANT => '',
            self::REVIEWS => '',
            self::NOTCREDIT => '',
            self::WRONGNUMBER => '',
            self::MAINTENANCE => '',
            self::LTD => '',
        ];
    }
}
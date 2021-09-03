<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class DriverCategory extends ReadableEnum {
    public const A = 'А';
    public const A1 = 'А1';
    public const B = 'В';
    public const BE = 'ВE';
    public const B1 = 'В1';
    public const C = 'С';
    public const CE = 'СE';
    public const C1 = 'С1';
    public const C1E = 'С1E';
    public const D = 'D';
    public const DE = 'DE';
    public const D1 = 'D1';
    public const D1E = 'D1E';
    public const M = 'М';
    public const TM = 'Tm';
    public const TB = 'Tb';

    public static function values(): array
    {
        return [
            self::A,
            self::A1,
            self::B,
            self::BE,
            self::B1,
            self::C,
            self::CE,
            self::C1,
            self::C1E,
            self::D,
            self::DE,
            self::D1,
            self::D1E,
            self::M,
            self::TM,
            self::TB,
        ];
    }

    public static function readables(): array
    {
        return [
            self::A => 'Мотоциклы',
            self::A1 => 'Легкие мотоциклы',
            self::B => 'Легковые автомобили, небольшие грузовики (до 3,5 тонн)',
            self::BE => 'Легковые автомобили с прицепом',
            self::B1 => 'Трициклы',
            self::C => 'Грузовые автомобили (от 3,5 тонн)',
            self::CE => 'Грузовые автомобили с прицепом',
            self::C1 => 'Средние грузовики (от 3,5 до 7,5 тонн)',
            self::C1E => 'Средние грузовики с прицепом',
            self::D => 'Автобусы',
            self::DE => 'Автобусы с прицепом',
            self::D1 => 'Небольшие автобусы',
            self::D1E => 'Небольшие автобусы с прицепом',
            self::M => 'Мопеды',
            self::TM => 'Трамваи',
            self::TB => 'Троллейбусы',
        ];
    }
}
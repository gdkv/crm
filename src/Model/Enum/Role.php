<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class Role extends ReadableEnum
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_SUPERVISOR = 'supervisor';
    public const ROLE_OPERATOR = 'operator';
    public const ROLE_CREDIT = 'credit';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_RECEPTION = 'reception';

    public static function values(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_SUPERVISOR,
            self::ROLE_OPERATOR,
            self::ROLE_CREDIT,
            self::ROLE_MANAGER,
            self::ROLE_RECEPTION,
        ];
    }

    public static function readables(): array
    {
        return [
            self::ROLE_ADMIN => 'Администратор',
            self::ROLE_SUPERVISOR => 'Руководитель',
            self::ROLE_OPERATOR => 'Оператор',
            self::ROLE_CREDIT => 'Кредитный менеджер',
            self::ROLE_MANAGER => 'Менеджер по продажам',
            self::ROLE_RECEPTION => 'Ресепшионист',
        ];
    }
}
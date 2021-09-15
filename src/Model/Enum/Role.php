<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class Role extends ReadableEnum
{
    /**
     * заявка - полный доступ
     * пользователь - полный доступ
     * супервизоры - полный доступ
     * кредитная анкета - полный доступ
     * метки - полный доступ
     * доп. функции (перенос / рассылки / аналитика) - полный доступ
     */
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * заявка - полный доступ
     * пользователь - полный доступ
     * супервизоры - нет доступа
     * кредитная анкета - полный доступ
     * метки - нет доступа
     * доп. функции (перенос / рассылки / аналитика) - полный доступ
     */
    public const ROLE_SUPERVISOR = 'ROLE_SUPERVISOR';

    /**
     * заявка - полный доступ
     * кредитная анкета - только просмотр 
     * пользователь - нет доступа
     * доп. функции - нет доступа
     */
    public const ROLE_OPERATOR = 'ROLE_OPERATOR';

    /**
     * заявка - только просмотр 
     * кредитная анкета - полный доступ
     * пользователь - нет доступа
     * доп. функции - нет доступа
     */
    public const ROLE_CREDIT = 'ROLE_CREDIT';

    /**
     * заявка - только просмотр 
     * кредитная анкета - полный доступ
     * пользователь - нет доступа
     * доп. функции - нет доступа
     */
    public const ROLE_MANAGER = 'ROLE_MANAGER';

    /**
     * заявка - только просмотр + смена статуса
     * кредитная анкета - нет доступа
     * пользователь - нет доступа
     * доп. функции - нет доступа
     */
    public const ROLE_RECEPTION = 'ROLE_RECEPTION';

    /**
     * заявка - только просмотр (всех заявок?)
     * кредитная анкета - нет доступа
     * пользователь - нет доступа
     * доп. функции - нет доступа
     * ? ограничения в дате действия аккаунта
     */
    public const ROLE_GUEST = 'ROLE_GUEST';

    public static function values(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_SUPERVISOR,
            self::ROLE_OPERATOR,
            self::ROLE_CREDIT,
            self::ROLE_MANAGER,
            self::ROLE_RECEPTION,
            self::ROLE_GUEST,
        ];
    }

    public static function readables(): array
    {
        return [
            self::ROLE_ADMIN => 'admin',
            self::ROLE_SUPERVISOR => 'supervisor',
            self::ROLE_OPERATOR => 'operator',
            self::ROLE_CREDIT => 'credit',
            self::ROLE_MANAGER => 'manager',
            self::ROLE_RECEPTION => 'reception',
            self::ROLE_GUEST => 'guest',
        ];
    }
}
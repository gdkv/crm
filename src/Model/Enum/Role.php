<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class Role extends ReadableEnum
{
    /**
     * заявка - полный доступ
     * пользователь - полный доступ
     * кредитная анкета - полный доступ
     * доп. функции (перенос / рассылки / аналитика) - полный доступ
     */
    public const ROLE_ADMIN = 'admin';

    /**
     * заявка - полный доступ
     * пользователь - полный доступ !КРОМЕ supervisor
     * кредитная анкета - полный доступ
     * доп. функции (перенос / рассылки / аналитика) - полный доступ
     */
    public const ROLE_SUPERVISOR = 'supervisor';

    /**
     * заявка - полный доступ
     * кредитная анкета - только просмотр 
     * пользователь - нет доступа
     * доп. функции - нет доступа
     */
    public const ROLE_OPERATOR = 'operator';

    /**
     * заявка - только просмотр 
     * кредитная анкета - полный доступ
     * пользователь - нет доступа
     * доп. функции - нет доступа
     */
    public const ROLE_CREDIT = 'credit';

    /**
     * заявка - только просмотр 
     * кредитная анкета - полный доступ
     * пользователь - нет доступа
     * доп. функции - нет доступа
     */
    public const ROLE_MANAGER = 'manager';

    /**
     * заявка - только просмотр + смена статуса
     * кредитная анкета - нет доступа
     * пользователь - нет доступа
     * доп. функции - нет доступа
     */
    public const ROLE_RECEPTION = 'reception';

    /**
     * заявка - только просмотр (всех заявок?)
     * кредитная анкета - нет доступа
     * пользователь - нет доступа
     * доп. функции - нет доступа
     * ? ограничения в дате действия аккаунта
     */
    public const ROLE_GUEST = 'guest';

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
            self::ROLE_ADMIN => 'Администратор',
            self::ROLE_SUPERVISOR => 'Руководитель',
            self::ROLE_OPERATOR => 'Оператор',
            self::ROLE_CREDIT => 'Кредитный менеджер',
            self::ROLE_MANAGER => 'Менеджер по продажам',
            self::ROLE_RECEPTION => 'Ресепшионист',
            self::ROLE_GUEST => 'Гостевой',
        ];
    }
}
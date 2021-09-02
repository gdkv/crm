<?php
namespace App\Model\Enum;

use Elao\Enum\ReadableEnum;

final class CreditStatus extends ReadableEnum
{
    public const SEND = 'send';
    public const CHECK = 'check';
    public const PROCESSED = 'processed';
    public const SENT_BANK = 'sent_bank';
    public const SOLUTION_RECEIVED = 'solution_received';
    public const GIVEN = 'given';
    public const NO_DOCUMENTS = 'no_documents';
    public const NO_DRIVING_LICENSE = 'no_driving_license';
    public const FSSP = 'fssp';
    public const NOT_RELEVANT = 'not_relevant';
    public const NO_REGION = 'no_region';
    public const AGE = 'age';
    public const LOAN = 'loan';
    public const TAXI = 'taxi';
    public const CONSULTATION = 'consultation';
    public const NO_JOB = 'no_job';

    public static function values(): array
    {
        return [
            self::SEND,
            self::CHECK,
            self::PROCESSED,
            self::SENT_BANK,
            self::SOLUTION_RECEIVED,
            self::GIVEN,
            self::NO_DOCUMENTS,
            self::NO_DRIVING_LICENSE,
            self::FSSP,
            self::NOT_RELEVANT,
            self::NO_REGION,
            self::AGE,
            self::LOAN,
            self::TAXI,
            self::CONSULTATION,
            self::NO_JOB,
        ];
    }

    public static function readables(): array
    {
        return [
            self::SEND => 'Отправить',
            self::CHECK => 'Проверить',
            self::PROCESSED => 'Оформляется',
            self::SENT_BANK => 'Отправлена в банк',
            self::SOLUTION_RECEIVED => 'Получено решение',
            self::GIVEN => 'Выдан',
            self::NO_DOCUMENTS => 'Нет 2 документа',
            self::NO_DRIVING_LICENSE => 'Нет ВУ',
            self::FSSP => 'ФССП',
            self::NOT_RELEVANT => 'Не актуально',
            self::NO_REGION => 'Нет региона',
            self::AGE => 'Возраст',
            self::LOAN => 'Имеется кредит',
            self::TAXI => 'Такси',
            self::CONSULTATION => 'Консультация',
            self::NO_JOB => 'Нет работы',
        ];
    }
}
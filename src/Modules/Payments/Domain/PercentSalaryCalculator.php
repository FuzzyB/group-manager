<?php


namespace App\Modules\Payments\Domain;


use App\Modules\Payments\Infrastructure\SalaryCalculatorInterface;
use Cassandra\Date;
use DateTime;

class PercentSalaryCalculator implements SalaryCalculatorInterface
{

    const METHOD_TYPE = 'percent';

    public function __construct()
    {
    }

    public function calcSalary(): int
    {
        return 0;
    }

    public function getBonusType(): string
    {
        return self::METHOD_TYPE;
    }

    public function calcBonus(DateTime $startOfWorkDay, $baseSalary): int
    {
        return 0;
    }
}

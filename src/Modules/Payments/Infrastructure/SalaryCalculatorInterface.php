<?php


namespace App\Modules\Payments\Infrastructure;


use DateTime;

interface SalaryCalculatorInterface
{
    public function calcSalary(): int;

    public function getBonusType(): string;

    public function calcBonus(DateTime $startOfWorkDay, $baseSalary): int;
}

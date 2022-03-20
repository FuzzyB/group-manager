<?php


namespace App\Modules\Payments\Infrastructure;


use App\Modules\Payments\Domain\Employee;
use DateTime;

interface SalaryCalculatorInterface
{
    public function calcSalary(): int;

    public function getBonusType(): string;

    public function setCalculationDate(\DateTimeImmutable $startOfWorkDate): void;

    public function setEmployee(Employee $employee): void;

    public function getBonus(): int;
}

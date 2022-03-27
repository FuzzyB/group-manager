<?php


namespace App\Modules\Payments\Domain\Interfaces;


use App\Modules\Payments\Domain\Entity\Employee;

interface SalaryCalculatorInterface
{
    public function calcSalary(): int;

    public function getBonusType(): string;

    public function getBonus(): int;
}

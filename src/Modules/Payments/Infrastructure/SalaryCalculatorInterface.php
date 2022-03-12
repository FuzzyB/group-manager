<?php


namespace App\Modules\Payments\Infrastructure;


use DateTime;

interface SalaryCalculatorInterface
{
    public function calcSalary(): int;

    public function getBonusType(): string;

    public function getBonus(): int;

    public function setBaseSalary(int $baseSalary): void;

    public function setStartOfWorkDate(\DateTimeImmutable $startOfWorkDate): void;

    public function setCalculationDate(\DateTimeImmutable $startOfWorkDate): void;

    public function setBonusValue(float $percentBonus): void;

    public function setEndOfWorkDate(?\DateTimeImmutable $endOfWorkDate): void;

    public function getDaysWorkedInCalcMonth();

    public function setEmployee(\App\Modules\Payments\Domain\Employee $employee): void;
}

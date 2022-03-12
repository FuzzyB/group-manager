<?php


namespace App\Modules\Payments\Domain;


use App\Modules\Payments\Infrastructure\SalaryCalculatorInterface;

class AmountSalaryCalculator implements SalaryCalculatorInterface
{

    public function calcSalary(): int
    {
        // TODO: Implement calcSalary() method.
    }

    public function getBonusType(): string
    {
        // TODO: Implement getBonusType() method.
    }

    public function getBonus(): int
    {
        // TODO: Implement getBonus() method.
    }

    public function setBaseSalary(int $baseSalary): void
    {
        // TODO: Implement setBaseSalary() method.
    }

    public function setStartOfWorkDate(\DateTimeImmutable $startOfWorkDate): void
    {
        // TODO: Implement setStartOfWorkDate() method.
    }

    public function setCalculationDate(\DateTimeImmutable $startOfWorkDate): void
    {
        // TODO: Implement setCalculationDate() method.
    }

    public function setBonusValue(float $percentBonus): void
    {
        // TODO: Implement setBonusValue() method.
    }

    public function setEndOfWorkDate(?\DateTimeImmutable $endOfWorkDate): void
    {
        // TODO: Implement setEndOfWorkDate() method.
    }

    public function getDaysWorkedInCalcMonth()
    {
        // TODO: Implement getDaysWorkedInCalcMonth() method.
    }

    public function setEmployee(\App\Modules\Payments\Domain\Employee $employee): void
    {
        // TODO: Implement setEmployee() method.
    }
}

<?php

namespace App\Modules\Payments\Domain;

use App\Modules\Payments\Infrastructure\SalaryCalculatorInterface;

class PercentSalaryCalculator extends SalaryCalculator implements SalaryCalculatorInterface
{
    const METHOD_TYPE = 'percent';
    public float $bonusValue;
    public int $baseSalary;
    public \DateTimeImmutable $startOfWorkDate;
    public \DateTimeImmutable $calculationDate;
    public ?\DateTimeImmutable $endOfWorkDate;

    /**
     * @param float $bonusPercent
     */
    public function __construct(float $bonusPercent)
    {
        $this->bonusValue = $bonusPercent;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function calcSalary(): int
    {
        if ($this->workedWholeMonth()) {
            $salary = $this->baseSalary + $this->getBonus();
        } else {
            $days = $this->getDaysWorkedInCalcMonth();
            $salaryPerDay = $this->baseSalary/$this->getDaysQuantityInCalcMonth();
            $salary = floor($days * $salaryPerDay);
        }

        return $salary;
    }

    /**
     * @return string
     */
    public function getBonusType(): string
    {
        return self::METHOD_TYPE;
    }

    /**
     * @return int
     */
    public function getBonus(): int
    {
        if ($this->bonusIsAvailable()) {
            return floor($this->baseSalary * $this->bonusValue);
        }

        return 0;
    }

    /**
     * @return bool
     */
    private function bonusIsAvailable():bool
    {
        $minExperienceDate = $this->startOfWorkDate->add(new \DateInterval('P1M'));
        return $minExperienceDate < $this->calculationDate;
    }

    public function setEmployee(\App\Modules\Payments\Domain\Employee $employee): void
    {
        $this->setEndOfWorkDate($employee->getEndOfWorkDate());
        $this->setStartOfWorkDate($employee->getStartOfWorkDate());
        $this->setBaseSalary($employee->getBaseSalary());
    }
}

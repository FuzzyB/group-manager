<?php

namespace App\Modules\Payments\Domain;

use App\Modules\Payments\Infrastructure\SalaryCalculatorInterface;

class AmountSalaryCalculator extends SalaryCalculator implements SalaryCalculatorInterface
{
    const METHOD_TYPE = 'amount';
    const MAX_EXPERIENCE_FOR_BONUS = 10;
    public float $bonusValue;
    public int $baseSalary;
    public \DateTimeImmutable $startOfWorkDate;
    public \DateTimeImmutable $calculationDate;
    public ?\DateTimeImmutable $endOfWorkDate;

    public function __construct(float $bonusValue)
    {
        $this->bonusValue = $bonusValue;
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

    public function getBonusType(): string
    {
        return self::METHOD_TYPE;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getBonus(): int
    {
        if ($this->bonusIsAvailable()) {
            return $this->getExperienceInYears() * $this->bonusValue;
        }

        return 0;
    }

    /**
     * @return bool
     */
    private function bonusIsAvailable(): bool
    {
        $minExperienceDate = $this->startOfWorkDate->add(new \DateInterval('P1Y'));
        return $minExperienceDate < $this->calculationDate;
    }

    /**
     * @param Employee $employee
     * @return void
     */
    public function setEmployee(Employee $employee): void
    {
        $this->setEndOfWorkDate($employee->getEndOfWorkDate());
        $this->setStartOfWorkDate($employee->getStartOfWorkDate());
        $this->setBaseSalary($employee->getBaseSalary());
    }

    /**
     * @return int
     * @throws \Exception
     */
    private function getExperienceInYears(): int
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $interval = $firstDayDate->diff($this->startOfWorkDate);
        $years = (int)$interval->format('%y');
        return $years <= 10 ? $years : self::MAX_EXPERIENCE_FOR_BONUS;
    }

    /**
     * @param float $bonusValue
     * @return void
     */
    public function setBonusValue(float $bonusValue): void
    {
        $this->bonusValue = $bonusValue;
    }
}

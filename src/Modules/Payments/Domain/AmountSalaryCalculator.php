<?php

namespace App\Modules\Payments\Domain;

use App\Modules\Payments\Domain\Interfaces\SalaryCalculatorInterface;

class AmountSalaryCalculator extends SalaryCalculator implements SalaryCalculatorInterface
{
    const METHOD_TYPE = 'amount';
    const MAX_EXPERIENCE_FOR_BONUS = 10;
    public float $bonusValue;
    public int $baseSalary;
    public \DateTimeImmutable $startOfWorkDate;
    public \DateTimeImmutable $calculationDate;
    public ?\DateTimeImmutable $endOfWorkDate;

    /**
     * @param float $bonusPercent
     * @param \DateTimeImmutable $reportDate
     * @param \DateTimeImmutable|null $endOfWorkDate
     * @param \DateTimeImmutable $startOfWorkDate
     * @param int $baseSalary
     */
    public function __construct(
        float $bonusPercent,
        \DateTimeImmutable $reportDate,
        ?\DateTimeImmutable $endOfWorkDate,
        \DateTimeImmutable $startOfWorkDate,
        int $baseSalary
    )
    {
        $this->bonusValue = $bonusPercent;
        $this->calculationDate = $reportDate;
        $this->endOfWorkDate = $endOfWorkDate;
        $this->startOfWorkDate = $startOfWorkDate;
        $this->baseSalary = $baseSalary;
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
     * @return int
     * @throws \Exception
     */
    private function getExperienceInYears(): int
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $interval = $firstDayDate->diff($this->startOfWorkDate);
        $years = (int)$interval->format('%y');
        return min($years, self::MAX_EXPERIENCE_FOR_BONUS);
    }
}

<?php


namespace App\Modules\Payments\Domain;


use App\Modules\Payments\Infrastructure\SalaryCalculatorInterface;


class PercentSalaryCalculator implements SalaryCalculatorInterface
{

    const METHOD_TYPE = 'percent';
    private float $bonusPercent;
    private int $baseSalary;
    private \DateTimeImmutable $startOfWorkDate;
    private \DateTimeImmutable $calculationDate;
    private ?\DateTimeImmutable $endOfWorkDate;

    public function __construct(float $bonusPercent)
    {
        $this->bonusPercent = $bonusPercent;
    }

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

    public function getBonus(): int
    {
        if ($this->bonusIsAvailable()) {
            return floor($this->baseSalary * $this->bonusPercent);
        }

        return 0;
    }

    public function setBaseSalary(int $baseSalary): void
    {
        $this->baseSalary = $baseSalary;
    }

    public function setStartOfWorkDate(\DateTimeImmutable $startOfWorkDate): void
    {
        $this->startOfWorkDate = $startOfWorkDate;
    }

    public function setCalculationDate(\DateTimeImmutable $date): void
    {
        $this->calculationDate = $date;
    }
    public function setBonusValue(float $percentBonus): void
    {
        $this->bonusPercent = $percentBonus;
    }

    private function bonusIsAvailable():bool
    {
        $minExperienceDate = $this->startOfWorkDate->add(new \DateInterval('P1M'));
        return $minExperienceDate < $this->calculationDate;
    }

    private function salaryIsAvailable(): bool
    {
        $diff = $this->calculationDate->diff($this->startOfWorkDate);

        return (int)$diff->format('%d') > 0;
    }

    /**
     * @return int|string
     * @throws \Exception
     */
    public function getDaysWorkedInCalcMonth(): int
    {
        if ($this->workedWholeMonth()) {
            return $this->getDaysQuantityInCalcMonth();
        } elseif ($this->workedPartOfMonth()) {
            return $this->countWorkingDays();
        }

        return 0;
    }

    public function setEndOfWorkDate(?\DateTimeImmutable $endOfWorkDate): void
    {
        $this->endOfWorkDate = $endOfWorkDate;
    }

    private function workedPartOfMonth()
    {
        return $this->wasEmployedInTheMiddleOfCalcMonth()
            || $this->wasFiredInTheMiddleOfCalcMonth();
    }

    private function wasFiredInTheMiddleOfCalcMonth(): bool
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $firstDayOfNextMonth = $firstDayDate->add(new \DateInterval('P1M'));

        return !empty($this->endOfWorkDate) &&
            $this->endOfWorkDate < $firstDayOfNextMonth &&
            $this->endOfWorkDate >= $firstDayDate;
    }

    private function wasEmployedInTheMiddleOfCalcMonth(): bool
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $secondDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-02'));
        $firstDayOfNextMonth = $firstDayDate->add(new \DateInterval('P1M'));

        return $this->startOfWorkDate >= $secondDayDate && $this->startOfWorkDate < $firstDayOfNextMonth;
    }

    private function workedWholeMonth(): bool
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $firstDayOfNextMonth = $firstDayDate->add(new \DateInterval('P1M'));

        return ($this->startOfWorkDate <= $firstDayDate) &&
            (empty($this->endOfWorkDate) || $this->endOfWorkDate >= $firstDayOfNextMonth);
    }

    private function countWorkingDays(): int
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $firstDayOfNextMonth = $firstDayDate->add(new \DateInterval('P1M'));
        $days = 0;
        if($this->wasEmployedInTheMiddleOfCalcMonth() && !$this->wasFiredInTheMiddleOfCalcMonth()) {
            $interval = $firstDayOfNextMonth->diff($this->startOfWorkDate);
            $days = (int)$interval->format('%d');
        }

        if($this->wasEmployedInTheMiddleOfCalcMonth() && $this->wasFiredInTheMiddleOfCalcMonth()) {
            $interval = $this->endOfWorkDate->diff($this->startOfWorkDate);
            $days = (int)$interval->format('%d')+1;
        }

        if(!$this->wasEmployedInTheMiddleOfCalcMonth() && $this->wasFiredInTheMiddleOfCalcMonth()) {
            $interval = $this->endOfWorkDate->diff($firstDayDate);
            $days = (int)$interval->format('%d') + 1;
        }

        if(!$this->wasEmployedInTheMiddleOfCalcMonth() && !$this->wasFiredInTheMiddleOfCalcMonth()) {
            $days = (int)$this->calculationDate->format('t');
        }

        return $days;
    }

    private function getDaysQuantityInCalcMonth()
    {
        return (int)$this->calculationDate->format('t');
    }

    public function setEmployee(\App\Modules\Payments\Domain\Employee $employee): void
    {
        $this->setEndOfWorkDate($employee->getEndOfWorkDate());
        $this->setStartOfWorkDate($employee->getStartOfWorkDate());
        $this->setBaseSalary($employee->getBaseSalary());
    }
}

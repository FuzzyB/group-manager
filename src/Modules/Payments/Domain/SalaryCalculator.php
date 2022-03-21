<?php

namespace App\Modules\Payments\Domain;

abstract class SalaryCalculator
{
    abstract public function getBonusType(): string;

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

    /**
     * @param \DateTimeImmutable $date
     * @return void
     */
    public function setCalculationDate(\DateTimeImmutable $date): void
    {
        $this->calculationDate = $date;
    }

    /**
     * @return int
     */
    public function getDaysQuantityInCalcMonth()
    {
        return (int)$this->calculationDate->format('t');
    }

    /**
     * @param \DateTimeImmutable $startOfWorkDate
     * @return void
     */
    public function setStartOfWorkDate(\DateTimeImmutable $startOfWorkDate): void
    {
        $this->startOfWorkDate = $startOfWorkDate;
    }

    /**
     * @param int $baseSalary
     * @return void
     */
    public function setBaseSalary(int $baseSalary): void
    {
        $this->baseSalary = $baseSalary;
    }

    /**
     * @param float $bonusValue
     * @return void
     */
    public function setBonusValue(float $bonusValue): void
    {
        $this->bonusValue = $bonusValue;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function countWorkingDays(): int
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

    /**
     * @return bool
     * @throws \Exception
     */
    public function workedWholeMonth(): bool
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $firstDayOfNextMonth = $firstDayDate->add(new \DateInterval('P1M'));

        return ($this->startOfWorkDate <= $firstDayDate) &&
            (empty($this->endOfWorkDate) || $this->endOfWorkDate >= $firstDayOfNextMonth);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function workedPartOfMonth()
    {
        return $this->wasEmployedInTheMiddleOfCalcMonth()
            || $this->wasFiredInTheMiddleOfCalcMonth();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function wasFiredInTheMiddleOfCalcMonth(): bool
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $firstDayOfNextMonth = $firstDayDate->add(new \DateInterval('P1M'));

        return !empty($this->endOfWorkDate) &&
            $this->endOfWorkDate < $firstDayOfNextMonth &&
            $this->endOfWorkDate >= $firstDayDate;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function wasEmployedInTheMiddleOfCalcMonth(): bool
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $secondDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-02'));
        $firstDayOfNextMonth = $firstDayDate->add(new \DateInterval('P1M'));

        return $this->startOfWorkDate >= $secondDayDate && $this->startOfWorkDate < $firstDayOfNextMonth;
    }

    /**
     * @param \DateTimeImmutable|null $endOfWorkDate
     * @return void
     */
    public function setEndOfWorkDate(?\DateTimeImmutable $endOfWorkDate): void
    {
        $this->endOfWorkDate = $endOfWorkDate;
    }
}

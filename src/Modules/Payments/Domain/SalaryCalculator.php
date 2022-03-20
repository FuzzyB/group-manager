<?php


namespace App\Modules\Payments\Domain;


abstract class SalaryCalculator
{
    abstract public function getBonusType(): string;

    /**
     * @return int|string
     * @throws \Exception
     */
    protected function getDaysWorkedInCalcMonth(): int
    {
        if ($this->workedWholeMonth()) {
            return $this->getDaysQuantityInCalcMonth();
        } elseif ($this->workedPartOfMonth()) {
            return $this->countWorkingDays();
        }

        return 0;
    }

    public function setCalculationDate(\DateTimeImmutable $date): void
    {
        $this->calculationDate = $date;
    }

    protected function getDaysQuantityInCalcMonth()
    {
        return (int)$this->calculationDate->format('t');
    }


    public function setStartOfWorkDate(\DateTimeImmutable $startOfWorkDate): void
    {
        $this->startOfWorkDate = $startOfWorkDate;
    }

    public function setBaseSalary(int $baseSalary): void
    {
        $this->baseSalary = $baseSalary;
    }

    protected function countWorkingDays(): int
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

    protected function workedWholeMonth(): bool
    {
        $firstDayDate = new \DateTimeImmutable($this->calculationDate->format('Y-m-01'));
        $firstDayOfNextMonth = $firstDayDate->add(new \DateInterval('P1M'));

        return ($this->startOfWorkDate <= $firstDayDate) &&
            (empty($this->endOfWorkDate) || $this->endOfWorkDate >= $firstDayOfNextMonth);
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

    public function setEndOfWorkDate(?\DateTimeImmutable $endOfWorkDate): void
    {
        $this->endOfWorkDate = $endOfWorkDate;
    }
}

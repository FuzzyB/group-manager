<?php


namespace App\Modules\Payments\Domain\Entity;

use App\Modules\Payments\Domain\AmountSalaryCalculator;
use App\Modules\Payments\Domain\Interfaces\SalaryCalculatorInterface;
use App\Modules\Payments\Domain\PercentSalaryCalculator;
use JetBrains\PhpStorm\Pure;

class Department
{
    const BONUS_TYPE_PERCENT = 'percent';
    const BONUS_TYPE_AMOUNT = 'amount';
    private int $id;
    private string $name;
    private string $bonusType;
    private int|float $bonusValue;

    public function __construct(int $id, string $name, string $bonusType, int|float $bonusValue)
    {
        $this->id = $id;
        $this->name = $name;
        $this->bonusType = $bonusType;
        $this->bonusValue = $bonusValue;
    }

    /**
     * @param \DateTimeImmutable $reportDate
     * @param \DateTimeImmutable|null $endOfWorkDate
     * @param \DateTimeImmutable $startOfWorkDate
     * @param int $baseSalary
     * @return SalaryCalculatorInterface
     */
    #[Pure] public function getSalaryCalculator(
        \DateTimeImmutable $reportDate,
        ?\DateTimeImmutable $endOfWorkDate,
        \DateTimeImmutable $startOfWorkDate,
        int $baseSalary
    ): SalaryCalculatorInterface
    {
        $bonusValue = $this->bonusValue;
        if ($this->bonusType === self::BONUS_TYPE_PERCENT) {
            $calculator = new PercentSalaryCalculator(
                $bonusValue,
                $reportDate,
                $endOfWorkDate,
                $startOfWorkDate,
                $baseSalary);
        } else {
            $calculator = new AmountSalaryCalculator(
                $bonusValue,
                $reportDate,
                $endOfWorkDate,
                $startOfWorkDate,
                $baseSalary);
        }

        return $calculator;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}

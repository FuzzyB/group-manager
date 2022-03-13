<?php


namespace App\Modules\Payments\Domain;


use App\Modules\Payments\Infrastructure\EmployeeRepositoryInterface;
use App\Modules\Payments\Infrastructure\SalaryCalculatorInterface;

class Department
{

    const BONUS_TYPE_PERCENT = 'percent';
    const BONUS_TYPE_AMOUNT = 'amount';
    private $employeeRepository;
    private int $id;

    public function __construct(int $id, string $name, string $bonusType, int|float $bonusValue)
    {
        $this->id = $id;
        $this->name = $name;
        $this->bonusType = $bonusType;
        $this->bonusValue = $bonusValue;
    }

    public function getSalaryCalculator(): SalaryCalculatorInterface
    {
        $onlyPercent = true;
        if ($this->bonusType === self::BONUS_TYPE_PERCENT || $onlyPercent) {
            $calculator = new PercentSalaryCalculator(0.3);
            $calculator->setBonusValue($this->bonusValue);

            return $calculator;
        }

        return new AmountSalaryCalculator();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

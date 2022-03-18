<?php


namespace App\Modules\Payments\Domain;


use App\Modules\Payments\Infrastructure\EmployeeRepositoryInterface;
use App\Modules\Payments\Infrastructure\SalaryCalculatorInterface;
use App\Entity\Department as DepartmentEntity;

class Department
{

    const BONUS_TYPE_PERCENT = 'percent';
    const BONUS_TYPE_AMOUNT = 'amount';
    private int $id;
    private string $name;
    private string $bonusType;
    private int|float $bonusValue;
    private DepartmentEntity $entity;

    public function __construct(int $id, string $name, string $bonusType, int|float $bonusValue, DepartmentEntity $entity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->bonusType = $bonusType;
        $this->bonusValue = $bonusValue;
        $this->entity = $entity;
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

    /**
     * @return DepartmentEntity
     */
    public function getEntity(): DepartmentEntity
    {
        return $this->entity;
    }

    /**
     * @param DepartmentEntity $entity
     */
    public function setEntity(DepartmentEntity $entity): void
    {
        $this->entity = $entity;
    }
}

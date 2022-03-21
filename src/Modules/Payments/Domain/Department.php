<?php


namespace App\Modules\Payments\Domain;

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

    /**
     * @return SalaryCalculatorInterface
     */
    public function getSalaryCalculator(): SalaryCalculatorInterface
    {
        $bonusValue = $this->entity->getBonusValue();
        if ($this->bonusType === self::BONUS_TYPE_PERCENT) {
            $calculator = new PercentSalaryCalculator($bonusValue);
        } else {
            $calculator = new AmountSalaryCalculator($bonusValue);
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

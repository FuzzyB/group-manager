<?php


namespace App\Tests\src\Modules\Payments\Domain;


use App\Modules\Payments\Domain\AmountSalaryCalculator;
use App\Modules\Payments\Domain\Department;
use PHPUnit\Framework\TestCase;

class AmountSalaryCalculatorTest extends TestCase
{
    public function setUp(): void
    {
        $departamentEntity = new \App\Entity\Department();
        $departamentEntity->setBonusValue(10000);
        $this->department = new Department(2, 'Accountant', Department::BONUS_TYPE_AMOUNT, 10000, $departamentEntity);
    }

    /** @dataProvider calcBonusProvider */
    public function testCalcBonus($calculationDate, $startOfWorkDate, $baseSalary, $percentBonus, $expectedSalary)
    {
        $salaryCalculator = $this->department->getSalaryCalculator();
        $salaryCalculator->setBaseSalary($baseSalary);
        $salaryCalculator->setStartOfWorkDate($startOfWorkDate);
        $salaryCalculator->setBonusValue($percentBonus);
        $salaryCalculator->setCalculationDate($calculationDate);
        $this->assertEquals($expectedSalary, $salaryCalculator->getBonus());
    }

    public function calcBonusProvider()
    {
        return [
            'new employee' => [new \DateTimeImmutable(), new \DateTimeImmutable(), 110000, 20000, 0],
            'working less than 1 month' => [new \DateTimeImmutable(), new \DateTimeImmutable('-20 days'), 110000, 50000, 0],
            '4 years experience' => [new \DateTimeImmutable(), new \DateTimeImmutable('-5 years'), 110000, 10000, 40000],
            'Unemployed' => [new \DateTimeImmutable('-6 years'), new \DateTimeImmutable('-5 years'), 110000, 12000, 0],
        ];
    }
}

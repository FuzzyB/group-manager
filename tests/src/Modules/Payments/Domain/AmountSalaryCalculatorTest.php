<?php


namespace App\Tests\src\Modules\Payments\Domain;


use App\Modules\Payments\Domain\Entity\Department;
use PHPUnit\Framework\TestCase;

class AmountSalaryCalculatorTest extends TestCase
{
    public function setUp(): void
    {
        $departamentEntity = new \App\Modules\Payments\Infrastructure\Entity\Department();
        $departamentEntity->setBonusValue(10000);

    }

    /** @dataProvider calcBonusProvider */
    public function testCalcBonus($calculationDate, $endOfWorkDate, $startOfWorkDate, $baseSalary, $expectedSalary)
    {
        $department = new Department(2, 'Accountant', Department::BONUS_TYPE_AMOUNT, 10000);
        $salaryCalculator = $department->getSalaryCalculator($calculationDate, $endOfWorkDate, $startOfWorkDate, $baseSalary);

        $this->assertEquals($expectedSalary, $salaryCalculator->getBonus());
    }

    public function calcBonusProvider()
    {
        return [
            'new employee' => [new \DateTimeImmutable(), null, new \DateTimeImmutable(), 110000, 0],
            'working less than 1 month' => [new \DateTimeImmutable(), new \DateTimeImmutable('-1 year'), new \DateTimeImmutable('-20 days'), 110000, 0],
            '4 years experience' => [new \DateTimeImmutable(), null, new \DateTimeImmutable('-5 years'), 110000, 40000],
            'Unemployed' => [new \DateTimeImmutable('-6 years'), null, new \DateTimeImmutable('-5 years'), 110000, 0],
        ];
    }
}

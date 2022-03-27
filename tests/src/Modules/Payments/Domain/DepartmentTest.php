<?php


namespace App\Tests\src\Modules\Payments\Domain;


use App\Modules\Payments\Domain\Entity\Department;
use App\Modules\Payments\Domain\Interfaces\SalaryCalculatorInterface;
use App\Modules\Payments\ReadRepository\EmployeeRepository;
use PHPUnit\Framework\TestCase;

class DepartmentTest extends TestCase
{
    private $department;

    /** @dataProvider calcBonusProvider */
    public function testGetSalaryCalculator($calculationDate, $endOfWorkDate, $startOfWorkDate, $baseSalary, $expectedSalary)
    {
        $department = new Department(2, 'Accountant', Department::BONUS_TYPE_AMOUNT, 10000);
        $salaryCalculator = $department->getSalaryCalculator($calculationDate, $endOfWorkDate, $startOfWorkDate, $baseSalary);

        $this->assertInstanceOf(SalaryCalculatorInterface::class, $salaryCalculator);
    }

    public function calcBonusProvider()
    {
        return [
            'new employee' => [new \DateTimeImmutable(), null, new \DateTimeImmutable(), 110000, 0],
        ];
    }
}

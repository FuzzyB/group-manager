<?php


namespace App\Tests\src\Modules\Payments\Domain;


use App\Modules\Payments\Domain\Entity\Department;
use App\Modules\Payments\Domain\Interfaces\SalaryCalculatorInterface;
use App\Modules\Payments\ReadRepository\EmployeeRepository;
use PHPUnit\Framework\TestCase;

class DepartmentTest extends TestCase
{
    private $department;

    protected function setUp(): void
    {
        $departamentEntity = new \App\Modules\Payments\Infrastructure\Entity\Department();
        $departamentEntity->setBonusValue(10000);
        $this->department = new Department(2, 'Accountant', Department::BONUS_TYPE_AMOUNT, 10000, $departamentEntity);

    }

    public function testGetSalaryCalculator()
    {
        $calculator = $this->department->getSalaryCalculator(10000);

        $this->assertInstanceOf(SalaryCalculatorInterface::class, $calculator);
    }

}

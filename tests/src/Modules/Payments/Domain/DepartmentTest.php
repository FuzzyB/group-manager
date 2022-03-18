<?php


namespace App\Tests\src\Modules\Payments\Domain;


use App\Modules\Payments\Domain\Department;
use App\Modules\Payments\Infrastructure\SalaryCalculatorInterface;
use App\Modules\Payments\ReadRepository\EmployeeRepository;
use PHPUnit\Framework\TestCase;

class DepartmentTest extends TestCase
{
    private $department;

    protected function setUp(): void
    {

        $this->department = new Department();
    }
    public function testGetEmployeesIsTypeOf()
    {
        $employees = $this->department->getEmployees();
        $this->assertIsArray($employees);
    }

    public function testGetSalaryCalculator()
    {
        $calculator = $this->department->getSalaryCalculator();

        $this->assertInstanceOf(SalaryCalculatorInterface::class, $calculator);
    }

}

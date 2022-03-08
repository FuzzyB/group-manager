<?php


namespace App\Modules\Payments\Domain;


use App\Modules\Payments\Infrastructure\EmployeeRepositoryInterface;
use App\Modules\Payments\Infrastructure\SalaryCalculatorInterface;

class Department
{

    private $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getEmployees(): array
    {
        return $this->employeeRepository->getList();
    }

    public function getSalaryCalculator(): SalaryCalculatorInterface
    {
        return new PercentSalaryCalculator();
    }
}

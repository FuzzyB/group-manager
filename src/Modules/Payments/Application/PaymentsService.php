<?php


namespace App\Modules\Payments\Application;


use App\Modules\Payments\Domain\Department;
use App\Modules\Payments\Domain\Employee;
use App\Modules\Payments\Infrastructure\DepartmentRepositoryInterface;
use App\Modules\Payments\Infrastructure\EmployeeRepositoryInterface;

class PaymentsService
{

    private DepartmentRepositoryInterface $departmentRepository;
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository, EmployeeRepositoryInterface $employeeRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function generatePaymentList(\DateTimeImmutable $date): array
    {
        $departments = $this->departmentRepository->getList();
        $reportItems = [];
        /** @var Department $department */
        foreach ($departments as $department) {
            $employees = $this->employeeRepository->getByDepartmentId($department->getId());
            $reportItems = array_merge($reportItems, $this->getSalaryList($department, $employees, $date));
        }

        return $reportItems;
    }

    private function getSalaryList(Department $department, $employees, $reportDate): array
    {
        $salaryCalculator = $department->getSalaryCalculator();
        $departmentName = $department->getName();
        $reportItems = [];

        /** @var Employee $employee */
        foreach ($employees as $employee) {
            $salaryCalculator->setEmployee($employee);
            $salaryCalculator->setCalculationDate($reportDate);

            $item = [
                'name' => $employee->getName(),
                'surname' => $employee->getSurname(),
                'departmentName' => $departmentName,
                'bonusSalary' => $salaryCalculator->getBonus(),
                'salaryBonusType' => $salaryCalculator->getBonusType(),
                'salary' => $salaryCalculator->calcSalary(),
            ];
            $reportItems[] = $item;
        }

        return $reportItems;
    }
}

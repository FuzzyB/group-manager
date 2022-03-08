<?php


namespace App\Modules\Payments\Application;


class PaymentsService
{

    private $paymentsReadRepository;

    public function __construct($readRepository)
    {
        $this->paymentsReadRepository = $readRepository;
    }

    public function generatePaymentList(string $month)
    {
        $departments = $departmentRepository->getLis-t();
        foreach ($departments as $department) {
            $this->getSalaryList();
        }
        $department = new Department(); //factory
        $employees = $department->getEmployees();
        $salaryCalculator = $department->getSalaryCalculator();
        $departmentName = $department->getName();
        $reportItems = [];
        foreach ($employees as $employee) {
            $item = [
                'name' => $employee->getName(),
                'surname' => $employee->getSurname(),
                'departmentName' => $departmentName,
                'bonusSalary' => $salaryCalculator->calcBonus(
                    $employee->getStartOfWorkDate(),
                    $employee->getBaseSalary()
                ),
                'salaryBonusType' => $salaryCalculator->getBonusType(),
                'salary' => $salaryCalculator->calcSalary(
                    $employee->getStartOfWorkDate(),
                    $employee->getBaseSalary()
                ),
            ];
            $reportItems[] = $item;
        }

    }
}

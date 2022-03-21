<?php

namespace App\Modules\Payments\Application;

use App\Modules\Payments\Domain\Department;
use App\Modules\Payments\Domain\Employee;
use App\Modules\Payments\Infrastructure\DepartmentRepositoryInterface;
use App\Modules\Payments\Infrastructure\EmployeeRepositoryInterface;
use App\Repository\SalaryReportRepository;
use Psr\Log\LoggerInterface;

class PaymentsService
{
    private DepartmentRepositoryInterface $departmentRepository;
    private EmployeeRepositoryInterface $employeeRepository;
    private SalaryReportRepository $salaryReportRepository;
    private LoggerInterface $logger;

    /**
     * @param DepartmentRepositoryInterface $departmentRepository
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param SalaryReportRepository $salaryReportRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        EmployeeRepositoryInterface $employeeRepository,
        SalaryReportRepository $salaryReportRepository,
        LoggerInterface $logger
    )
    {
        $this->departmentRepository = $departmentRepository;
        $this->employeeRepository = $employeeRepository;
        $this->salaryReportRepository = $salaryReportRepository;
        $this->logger = $logger;
    }

    /**
     * @param \DateTimeImmutable $date
     * @return void
     * @throws \Exception
     */
    public function generatePaymentList(\DateTimeImmutable $date): void
    {
        $departments = $this->departmentRepository->getList();
        try {
            /** @var Department $department */
            foreach ($departments as $department) {
                $employees = $this->employeeRepository->getByDepartmentId($department->getId());
                $this->salaryReportRepository->saveSalaryList(
                    $this->getSalaryList($department, $employees, $date)
                );
            }
        } catch (\Exception $exception){
            //@todo handle retry on fail
            $this->logger->info('GeneratePaymentError: ' . $exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @param Department $department
     * @param array $employees
     * @param \DateTimeImmutable $reportDate
     * @return array
     */
    private function getSalaryList(Department $department, array $employees, \DateTimeImmutable $reportDate): array
    {
        $salaryCalculator = $department->getSalaryCalculator();
        $departmentName = $department->getName();
        $reportItems = [];

        /** @var Employee $employee */
        foreach ($employees as $employee) {
            $salaryCalculator->setEmployee($employee);
            $salaryCalculator->setCalculationDate($reportDate);

            $reportItems[] = [
                'name' => $employee->getName(),
                'surname' => $employee->getSurname(),
                'departmentName' => $departmentName,
                'bonusSalary' => $salaryCalculator->getBonus(),
                'salaryBonusType' => $salaryCalculator->getBonusType(),
                'salary' => $salaryCalculator->calcSalary(),
                'department' => $department->getEntity(),
                'employee' => $employee->getEntity(),
                'auDate' => $reportDate,
            ];
        }

        return $reportItems;
    }

    /**
     * @param mixed $filterCriteria
     * @return float|int|mixed|string
     */
    public function getSalaryReport(mixed $filterCriteria)
    {
        return $this->salaryReportRepository->getSalaryReport($filterCriteria);
    }
}

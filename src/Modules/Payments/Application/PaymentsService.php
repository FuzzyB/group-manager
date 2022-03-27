<?php

namespace App\Modules\Payments\Application;

use App\Modules\Payments\Domain\Entity\Department;
use App\Modules\Payments\Domain\Entity\Employee;
use App\Modules\Payments\Domain\Interfaces\DepartmentRepositoryInterface;
use App\Modules\Payments\Domain\Interfaces\EmployeeRepositoryInterface;
use App\Modules\Payments\Domain\Interfaces\SalaryCalculatorInterface;
use App\Modules\Payments\Infrastructure\Repository\SalaryReportRepository;
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
        $departmentName = $department->getName();
        $reportItems = [];

        /** @var Employee $employee */
        foreach ($employees as $employee) {
            $salaryCalculator = $this->initSalaryCalculator($reportDate, $department, $employee);

            $reportItems[] = [
                'name' => $employee->getName(),
                'surname' => $employee->getSurname(),
                'departmentName' => $departmentName,
                'bonusSalary' => $salaryCalculator->getBonus(),
                'salaryBonusType' => $salaryCalculator->getBonusType(),
                'salary' => $salaryCalculator->calcSalary(),
                'departmentId' => $department->getId(),
                'employeeId' => $employee->getId(),
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

    /**
     * @param \DateTimeImmutable $reportDate
     * @param Department $department
     * @param Employee $employee
     * @return SalaryCalculatorInterface
     */
    private function initSalaryCalculator(
        \DateTimeImmutable $reportDate,
        Department $department,
        Employee $employee
    ): SalaryCalculatorInterface
    {
        return $department->getSalaryCalculator(
            $reportDate,
            $employee->getEndOfWorkDate(),
            $employee->getStartOfWorkDate(),
            $employee->getBaseSalary()
        );
    }
}

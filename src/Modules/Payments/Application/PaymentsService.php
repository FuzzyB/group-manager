<?php


namespace App\Modules\Payments\Application;


use App\Entity\SalaryReport;
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

    public function generatePaymentList(\DateTimeImmutable $date): void
    {
        $departments = $this->departmentRepository->getList();
        try {
            /** @var Department $department */
            foreach ($departments as $department) {
                $employees = $this->employeeRepository->getByDepartmentId($department->getId());
                $this->salaryReportRepository->saveSalaryList($this->getSalaryList($department, $employees, $date));
            }
        } catch (\Exception $exception){
            //@todo handle retry on fail
            $this->logger->info('GeneratePaymentError: ' . $exception->getMessage());
            throw $exception;
        }
    }

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
            ];
        }

        return $reportItems;
    }

    public function getSalaryReport(mixed $filterCriteria)
    {
        $result = $this->salaryReportRepository->findAll();
        return $result;
    }
}

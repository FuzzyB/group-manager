<?php


namespace App\Modules\Payments\Domain\Factory;

use App\Modules\Payments\Domain\Entity\Employee;
use App\Modules\Payments\Infrastructure\Entity\Employee as EmployeeEntity;

class EmployeeFactory
{
    /**
     * @param EmployeeEntity $employeeEntity
     * @return Employee
     * @throws \Exception
     */
    public function create(EmployeeEntity $employeeEntity): Employee
    {
        /** @var string $endOfWork */
        $endOfWork = $employeeEntity->getEndOfWorkDate()?->format('Y-m-d H:i:s') ?? null;
        $endOfWorkDate = null;
        if ($endOfWork) {
            $endOfWorkDate = new \DateTimeImmutable($endOfWork);
        }
        $startOfWorkDate = $employeeEntity->getStartOfWorkDate()?->format('Y-m-d H:i:s') ?? null;
        $startOfWorkDate = new \DateTimeImmutable($startOfWorkDate);

        return new Employee(
            $employeeEntity->getId(),
            $employeeEntity->getBaseSalary(),
            $employeeEntity->getName(),
            $employeeEntity->getSurname(),
            $endOfWorkDate,
            $startOfWorkDate,
            $employeeEntity
        );
    }
}

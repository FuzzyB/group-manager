<?php


namespace App\Modules\Payments\ReadRepository;


use App\Modules\Payments\Domain\EmployeeFactory;
use App\Modules\Payments\Infrastructure\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{

    public function __construct(EmployeeFactory $employeeFactory)
    {
        $this->employeeFactory = $employeeFactory;
    }

    public function getByDepartmentId(int $departmentId): array
    {
        $queryResult = [
            [
                'id' => 1,
                'name' => 'Jan',
                'surname' => 'Kowalski',
                'baseSalary' => 110000,
                'end_of_work_date' => '',
                'start_of_work_date' => '',
            ],
            [
                'id' => 2,
                'name' => 'Sebastian',
                'surname' => 'Zamojski',
                'baseSalary' => 210000,
                'end_of_work_date' => '',
                'start_of_work_date' => '',
            ],
        ];

        foreach ($queryResult as $employeeConfiguration) {
            $employees[] = $this->employeeFactory->create($employeeConfiguration);
        }

        return $employees;
    }
}

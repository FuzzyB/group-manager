<?php


namespace App\Modules\Payments\Infrastructure;


interface EmployeeRepositoryInterface
{
    public function getByDepartmentId(int $departmentId): array;
}

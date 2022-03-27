<?php


namespace App\Modules\Payments\Domain\Interfaces;


interface EmployeeRepositoryInterface
{
    public function getByDepartmentId(int $departmentId): array;
}

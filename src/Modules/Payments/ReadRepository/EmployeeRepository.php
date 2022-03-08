<?php


namespace App\Modules\Payments\ReadRepository;


use App\Modules\Payments\Infrastructure\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{

    public function getList(): array
    {
        return [];
    }
}

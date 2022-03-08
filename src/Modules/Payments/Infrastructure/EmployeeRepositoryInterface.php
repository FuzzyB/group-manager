<?php


namespace App\Modules\Payments\Infrastructure;


interface EmployeeRepositoryInterface
{
    public function getList(): array;
}

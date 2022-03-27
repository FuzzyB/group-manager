<?php

namespace App\Modules\Payments\Domain\Interfaces;

interface DepartmentRepositoryInterface
{
    public function getList(): array;
}

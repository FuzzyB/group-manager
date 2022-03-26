<?php

namespace App\Modules\Payments\Domain\Factory;

use App\Modules\Payments\Domain\Entity\Department;
use App\Modules\Payments\Infrastructure\Entity\Department as DepartmentEntity;
use JetBrains\PhpStorm\Pure;

class DepartmentFactory
{
    /**
     * @param DepartmentEntity $departmentEntity
     * @return Department
     */
    #[Pure] public function create(DepartmentEntity $departmentEntity): Department
    {
        return new Department(
            $departmentEntity->getId(),
            $departmentEntity->getName(),
            $departmentEntity->getBonusType(),
            $departmentEntity->getBonusValue()
        );
    }
}

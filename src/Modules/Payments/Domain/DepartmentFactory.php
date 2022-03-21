<?php

namespace App\Modules\Payments\Domain;

use App\Entity\Department as DepartmentEntity;

class DepartmentFactory
{
    /**
     * @param DepartmentEntity $departmentEntity
     * @return Department
     */
    public function create(DepartmentEntity $departmentEntity)
    {
        return new Department(
            $departmentEntity->getId(),
            $departmentEntity->getName(),
            $departmentEntity->getBonusType(),
            $departmentEntity->getBonusValue(),
            $departmentEntity
        );
    }
}

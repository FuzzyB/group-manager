<?php


namespace App\Modules\Payments\ReadRepository;


use App\Modules\Payments\Domain\DepartmentFactory;
use App\Modules\Payments\Infrastructure\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    private DepartmentFactory $departmentFactory;

    public function __construct(DepartmentFactory $departmentFactory)
    {
        $this->departmentFactory = $departmentFactory;
    }

    public function getList()
    {
        $queryResult = [
            [
                'id' => 1,
                'name' => 'Ksiegowość',
                'bonusType' => 'percent',
                'bonusValue' => 0.3,
            ],
            [
                'id' => 2,
                'name' => 'Logistyka',
                'bonusType' => 'amount',
                'bonusValue' => 0.1,
            ],
        ];

        foreach ($queryResult as $deptConfiguration) {
            $departments[] = $this->departmentFactory->create($deptConfiguration);
        }

        return $departments;
    }
}

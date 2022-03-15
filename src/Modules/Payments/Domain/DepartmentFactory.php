<?php

namespace App\Modules\Payments\Domain;


class DepartmentFactory
{
    public function create($config)
    {
        $id = $config['id'];
        $name = $config['name'];
        $bonusType = $config['bonusType'];
        $bonusValue = $config['bonusValue'];

        return new Department($id, $name, $bonusType, $bonusValue);
    }
}

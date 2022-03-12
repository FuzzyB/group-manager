<?php


namespace App\Modules\Payments\Domain;


class EmployeeFactory
{
    public function create($config)
    {
        $endOfWorkDate = new \DateTimeImmutable($config['endOfWorkDate']);
        $startOfWorkDate = new \DateTimeImmutable($config['startOfWorkDate']);
        return new Employee($config['id'], $config['baseSalary'], $config['name'], $config['surname'], $endOfWorkDate, $startOfWorkDate);
    }
}

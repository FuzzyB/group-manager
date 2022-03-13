<?php


namespace App\Modules\Payments\Domain;


class EmployeeFactory
{
    public function create($config)
    {
        $endOfWorkDate = new \DateTimeImmutable($config['end_of_work_date']);
        $startOfWorkDate = new \DateTimeImmutable($config['start_of_work_date']);
        return new Employee($config['id'], $config['baseSalary'], $config['name'], $config['surname'], $endOfWorkDate, $startOfWorkDate);
    }
}

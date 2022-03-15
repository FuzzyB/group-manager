<?php


namespace App\Modules\Payments\Domain;


class EmployeeFactory
{
    /**
     * @param $config
     * @return Employee
     * @throws \Exception
     */
    public function create($config): Employee
    {
        /** @var string $endOfWork */
        $endOfWork = $config['endOfWorkDate']?->format('Y-m-d H:i:s') ?? null;
        $endOfWorkDate = null;
        if ($endOfWork) {
            $endOfWorkDate = new \DateTimeImmutable($endOfWork);
        }
        $startOfWorkDate = $config['startOfWorkDate']?->format('Y-m-d H:i:s') ?? null;
        $startOfWorkDate = new \DateTimeImmutable($startOfWorkDate);

        return new Employee($config['id'], $config['baseSalary'], $config['name'], $config['surname'], $endOfWorkDate, $startOfWorkDate);
    }
}

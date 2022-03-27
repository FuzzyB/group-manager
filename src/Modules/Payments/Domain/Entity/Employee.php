<?php


namespace App\Modules\Payments\Domain\Entity;

use App\Modules\Payments\Infrastructure\Entity\Employee as EmployeeEntity;

class Employee
{
    private int $id;
    private int $baseSalary;
    private string $name;
    private string $surname;
    private ?\DateTimeImmutable $endOfWorkDate;
    private \DateTimeImmutable $startOfWorkDate;
    private EmployeeEntity $entity;

    /**
     * @param int $id
     * @param int $baseSalary
     * @param string $name
     * @param string $surname
     * @param \DateTimeImmutable|null $endOfWorkDate
     * @param \DateTimeImmutable|null $startOfWorkDate
     * @param EmployeeEntity $employeeEntity
     */
    public function __construct(int $id,
        int $baseSalary,
        string $name,
        string $surname,
        ?\DateTimeImmutable $endOfWorkDate,
        ?\DateTimeImmutable $startOfWorkDate,
        EmployeeEntity $employeeEntity
    )
    {
        $this->id = $id;
        $this->baseSalary = $baseSalary;
        $this->name = $name;
        $this->surname = $surname;
        $this->endOfWorkDate = $endOfWorkDate;
        $this->startOfWorkDate = $startOfWorkDate;
        $this->entity = $employeeEntity;
    }

    /**
     * @return int
     */
    public function getBaseSalary(): int
    {
        return $this->baseSalary;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getEndOfWorkDate(): ?\DateTimeImmutable
    {
        return $this->endOfWorkDate;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartOfWorkDate(): \DateTimeImmutable
    {
        return $this->startOfWorkDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return EmployeeEntity
     */
    public function getEntity(): EmployeeEntity
    {
        return $this->entity;
    }

    /**
     * @param EmployeeEntity $entity
     */
    public function setEntity(EmployeeEntity $entity): void
    {
        $this->entity = $entity;
    }
}

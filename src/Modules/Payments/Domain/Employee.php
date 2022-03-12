<?php


namespace App\Modules\Payments\Domain;


class Employee
{
    private int $id;
    private int $baseSalary;
    private string $name;
    private string $surname;
    private \DateTimeImmutable $endOfWorkDate;
    private \DateTimeImmutable $startOfWorkDate;

    public function __construct(int $id,
        int $baseSalary,
        string $name,
        string $surname,
        \DateTimeImmutable $endOfWorkDate,
        \DateTimeImmutable $startOfWorkDate)
    {
        $this->id = $id;
        $this->baseSalary = $baseSalary;
        $this->name = $name;
        $this->surname = $surname;
        $this->endOfWorkDate = $endOfWorkDate;
        $this->startOfWorkDate = $startOfWorkDate;
    }

    public function setExperienceMonth(float|int $experience)
    {
        $this->experience = $experience;
    }

    public function getBaseSalary(): int
    {
        return $this->baseSalary;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getEndOfWorkDate(): \DateTimeImmutable
    {
        return $this->endOfWorkDate;
    }

    public function getStartOfWorkDate()
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
}

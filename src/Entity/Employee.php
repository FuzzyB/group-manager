<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $baseSalary;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $surname;

    #[ORM\Column(type: 'date', nullable: true)]
    private $endOfWorkDate;

    #[ORM\Column(type: 'date', nullable: true)]
    private $startOfWorkDate;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $fk_department_id;

    #[ORM\ManyToOne(targetEntity: Department::class, inversedBy: 'employees')]
    #[ORM\JoinColumn(nullable: false)]
    private $department;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseSalary(): ?int
    {
        return $this->baseSalary;
    }

    public function setBaseSalary(?int $baseSalary): self
    {
        $this->baseSalary = $baseSalary;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEndOfWorkDate(): ?\DateTimeInterface
    {
        return $this->endOfWorkDate;
    }

    public function setEndOfWorkDate(?\DateTimeInterface $endOfWorkDate): self
    {
        $this->endOfWorkDate = $endOfWorkDate;

        return $this;
    }

    public function getStartOfWorkDate(): ?\DateTimeInterface
    {
        return $this->startOfWorkDate;
    }

    public function setStartOfWorkDate(?\DateTimeInterface $startOfWorkDate): self
    {
        $this->startOfWorkDate = $startOfWorkDate;

        return $this;
    }

    public function getFkDepartmentId(): ?int
    {
        return $this->fk_department_id;
    }

    public function setFkDepartmentId(?int $fk_department_id): self
    {
        $this->fk_department_id = $fk_department_id;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }
}

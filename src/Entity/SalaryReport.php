<?php

namespace App\Entity;

use App\Repository\SalaryReportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalaryReportRepository::class)]
class SalaryReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $employeeName;

    #[ORM\Column(type: 'string', length: 255)]
    private $employeeSurname;

    #[ORM\Column(type: 'string', length: 255)]
    private $departmentName;

    #[ORM\Column(type: 'float', nullable: true)]
    private $bonusSalary;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $salaryBonusType;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $salary;

    #[ORM\ManyToOne(targetEntity: Department::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $department;

    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $employee;

    #[ORM\Column(type: 'date')]
    private $au_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeName(): ?string
    {
        return $this->employeeName;
    }

    public function setEmployeeName(string $employeeName): self
    {
        $this->employeeName = $employeeName;

        return $this;
    }

    public function getEmployeeSurname(): ?string
    {
        return $this->employeeSurname;
    }

    public function setEmployeeSurname(string $employeeSurname): self
    {
        $this->employeeSurname = $employeeSurname;

        return $this;
    }

    public function getDepartmentName(): ?string
    {
        return $this->departmentName;
    }

    public function setDepartmentName(string $departmentName): self
    {
        $this->departmentName = $departmentName;

        return $this;
    }

    public function getBonusSalary(): ?float
    {
        return $this->bonusSalary;
    }

    public function setBonusSalary(?float $bonusSalary): self
    {
        $this->bonusSalary = $bonusSalary;

        return $this;
    }

    public function getSalaryBonusType(): ?string
    {
        return $this->salaryBonusType;
    }

    public function setSalaryBonusType(?string $salaryBonusType): self
    {
        $this->salaryBonusType = $salaryBonusType;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(?int $salary): self
    {
        $this->salary = $salary;

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

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getAuDate(): ?\DateTimeInterface
    {
        return $this->au_date;
    }

    public function setAuDate(\DateTimeInterface $au_date): self
    {
        $this->au_date = $au_date;

        return $this;
    }
}

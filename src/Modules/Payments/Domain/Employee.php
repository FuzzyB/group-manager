<?php


namespace App\Modules\Payments\Domain;


class Employee
{
    private int|float $experience;

    public function getExperienceYears()
    {
        return floor($this->experience/12);
    }

    public function setExperienceMonth(float|int $experience)
    {
        $this->experience = $experience;
    }

    public function getSalary()
    {

    }
}

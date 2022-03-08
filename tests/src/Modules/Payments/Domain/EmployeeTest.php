<?php


namespace App\Tests\src\Modules\Payments\Domain;


use App\Modules\Payments\Domain\Employee;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{

    /** @dataProvider getExperiences */
    public function testGetExperience($experience, $expected)
    {
        $employee = new Employee();
        $employee->setExperienceMonth($experience);
        $this->assertEquals($expected, $employee->getExperienceYears());
    }

    public function getExperiences()
    {
        return [
            [
                15*12, 15
            ],
            [
                5*12+1, 5
            ],
            [
                5*12-1, 4
            ],
        ];
    }
}

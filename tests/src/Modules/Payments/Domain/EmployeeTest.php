<?php


namespace App\Tests\src\Modules\Payments\Domain;


use App\Modules\Payments\Domain\Employee;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{

    /** @dataProvider getExperiences */
    public function testGetExperience($experience, $expected)
    {
        $startOfWorkDate = new \DateTimeImmutable();
        $employeeEntity = new \App\Entity\Employee();

        $employee = new Employee(1, 11000, 'tester', 'jednostkowy', null, $startOfWorkDate, $employeeEntity);

        $this->assertEquals($expected, $employee->getExperienceYears());
    }

    public function getExperiences()
    {
        //@todo refactor to use start and End date of work
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

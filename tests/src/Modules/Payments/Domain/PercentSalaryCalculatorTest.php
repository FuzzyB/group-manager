<?php


namespace App\Tests\src\Modules\Payments\Domain;


use App\Modules\Payments\Domain\Department;
use App\Modules\Payments\Domain\Employee;
use App\Modules\Payments\Domain\PercentSalaryCalculator;
use PHPUnit\Framework\TestCase;

class PercentSalaryCalculatorTest extends TestCase
{
    /** @dataProvider calculateSalaryProvider */

    public function testCalculateSalary()
    {
        $salaryCalculator = new PercentSalaryCalculator();
        $this->assertEquals(234234, $salaryCalculator->calcSalary(new \DateTime(), 234234));
    }
    /** @dataProvider calcBonusProvider */
    public function testCalcBonus($startOfWorkDate, $baseSalary, $expectedSalary)
    {
        $calculator = new PercentSalaryCalculator();
        $this->assertEquals($expectedSalary, $calculator->calcBonus($startOfWorkDate, $baseSalary));
    }

    public function calcBonusProvider()
    {
        return [
            [new \DateTime(), 110000, 110000],
            [new \DateTime('-10 years'), 410000, 451000],
            [new \DateTime('-5 years'), 110000, 121000],
        ];
    }

    public function testCalcSalary()
    {

    }

    public function testGetBonusType()
    {

    }

    public function calculateSalaryProvider()
    {
        return [
            [ 1,2],
        ];
    }

}

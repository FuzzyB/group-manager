<?php


namespace App\Tests\src\Modules\Payments\Domain;

use App\Modules\Payments\Domain\Entity\Department;
use PHPUnit\Framework\TestCase;

class PercentSalaryCalculatorTest extends TestCase
{
    /** @var Department  */
    private Department $department;

    public function setUp(): void
    {
        $departamentEntity = new \App\Modules\Payments\Infrastructure\Entity\Department();
        $departamentEntity->setBonusValue(0.2);
        $this->department = new Department(1, 'Logistic', Department::BONUS_TYPE_PERCENT, 0.2, $departamentEntity);
    }

    /** @dataProvider calcBonusProvider */
    public function testCalcBonus($calculationDate, $startOfWorkDate, $baseSalary, $percentBonus, $expectedSalary)
    {
        $salaryCalculator = $this->department->getSalaryCalculator();
        $salaryCalculator->setBaseSalary($baseSalary);
        $salaryCalculator->setStartOfWorkDate($startOfWorkDate);
        $salaryCalculator->setBonusValue($percentBonus);
        $salaryCalculator->setCalculationDate($calculationDate);
        $this->assertEquals($expectedSalary, $salaryCalculator->getBonus());
    }

    /** @dataProvider calculateSalaryProvider */
    public function testCalculateSalary($startOfWorkDate, $endOfWorkDate, $calculationDate, $baseSalary, $percentBonus, $expectedSalary)
    {
        $salaryCalculator = $this->department->getSalaryCalculator();
        $salaryCalculator->setBaseSalary($baseSalary);
        $salaryCalculator->setStartOfWorkDate($startOfWorkDate);
        $salaryCalculator->setBonusValue($percentBonus);
        $salaryCalculator->setCalculationDate($calculationDate);
        $salaryCalculator->setEndOfWorkDate($endOfWorkDate);

        $this->assertEquals($expectedSalary, $salaryCalculator->calcSalary());
    }

    /** @dataProvider countWorkingDaysProvider */
    public function testCountWorkingDaysInMonth($startOfWorkDate, $endOfWorkDate, $calculationDate, $expectedDays) {
        $baseSalary = 0;
        $percentBonus = 0.10;
        $salaryCalculator = $this->department->getSalaryCalculator();
        $salaryCalculator->setBaseSalary($baseSalary);
        $salaryCalculator->setStartOfWorkDate($startOfWorkDate);
        $salaryCalculator->setEndOfWorkDate($endOfWorkDate);
        $salaryCalculator->setBonusValue($percentBonus);
        $salaryCalculator->setCalculationDate($calculationDate);

        $this->assertEquals($expectedDays, $salaryCalculator->getDaysWorkedInCalcMonth());
    }

    public function countWorkingDaysProvider()
    {
        return [
                'working start in the calc month' =>    [new \DateTimeImmutable('7 february 2022'), null, new \DateTimeImmutable('1 february 2022'), 22],
                'worked end in the calc month' =>       [new \DateTimeImmutable('1 february 2021'), new \DateTimeImmutable('13 february 2022'), new \DateTimeImmutable('1 february 2022'), 13],
                'worked part of the month' =>           [new \DateTimeImmutable('4 february 2022'), new \DateTimeImmutable('16 february 2022'), new \DateTimeImmutable('1 february 2022'), 13],
                'worked whole month' =>                 [new \DateTimeImmutable('1 february 2021'), null, new \DateTimeImmutable('1 february 2022'), 28],
                'worked one last day' =>                 [new \DateTimeImmutable('1 february 2021'), new \DateTimeImmutable('13 jun 2023'), new \DateTimeImmutable('1 february 2022'), 28],
                'not worked at the time' =>             [new \DateTimeImmutable('1 february 2021'), new \DateTimeImmutable('13 jun 2021'), new \DateTimeImmutable('1 february 2022'), 0],
        ];
    }

    public function calculateSalaryProvider(): array
    {
        return [                                    //startOfWorkDate, $endOfWorkDate, $calculationDate, $baseSalary, $percentBonus, $expectedSalary
            'working start in the calc month' =>    [new \DateTimeImmutable('7 february 2022'), null, new \DateTimeImmutable('1 february 2022'), 110000, 0.1, 86428],
            'worked end in the calc month' =>       [new \DateTimeImmutable('1 february 2021'), new \DateTimeImmutable('13 february 2022'), new \DateTimeImmutable('1 february 2022'), 110000, 0.1, 51071],
            'worked part of the month' =>           [new \DateTimeImmutable('4 february 2022'), new \DateTimeImmutable('16 february 2022'), new \DateTimeImmutable('1 february 2022'), 110000, 0.1, 51071],
            'worked whole month' =>                 [new \DateTimeImmutable('1 february 2021'), null, new \DateTimeImmutable('1 february 2022'), 110000, 0.1, 121000],
            'worked one last day' =>                [new \DateTimeImmutable('1 february 2021'), new \DateTimeImmutable('1 february 2022'), new \DateTimeImmutable('1 february 2022'), 110000, 0.1, 3928],
            'not worked at the time' =>             [new \DateTimeImmutable('1 february 2021'), new \DateTimeImmutable('13 jun 2021'), new \DateTimeImmutable('1 february 2022'), 110000, 0.1, 0],
       ];
    }

    public function calcBonusProvider()
    {
        return [
            'new employee' => [new \DateTimeImmutable(), new \DateTimeImmutable(), 110000, 0.1, 0],
            'working less than 1 month' => [new \DateTimeImmutable(), new \DateTimeImmutable('-20 days'), 110000, 0.1, 0],
            '5 years experience' => [new \DateTimeImmutable(), new \DateTimeImmutable('-5 years'), 110000, 0.1, 11000],
            'Unemployed' => [new \DateTimeImmutable('-6 years'), new \DateTimeImmutable('-5 years'), 110000, 0.1, 0],
        ];
    }
}

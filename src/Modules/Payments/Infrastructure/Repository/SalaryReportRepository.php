<?php

namespace App\Modules\Payments\Infrastructure\Repository;

use App\Modules\Payments\Infrastructure\Entity\Department;
use App\Modules\Payments\Infrastructure\Entity\Employee;
use App\Modules\Payments\Infrastructure\Entity\SalaryReport;
use App\Modules\Payments\Infrastructure\Form\FilterCriteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalaryReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalaryReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalaryReport[]    findAll()
 * @method SalaryReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalaryReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,
        DepartmentRepository $departmentRepository,
        EmployeeRepository $employeeRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->employeeRepository = $employeeRepository;
        parent::__construct($registry, SalaryReport::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SalaryReport $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(SalaryReport $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param array $salaryList
     * @return void
     */
    public function saveSalaryList(array $salaryList)
    {
        $batchSize = 100;
        $counter = 0;
        foreach ($salaryList as $list) {

            /** @var Department $department */
            $department = $this->departmentRepository->find($list['departmentId']);
            /** @var Employee $employee */
            $employee = $this->employeeRepository->find($list['employeeId']);

            $reportItem = new SalaryReport();
            $reportItem->setEmployeeName($list['name']);
            $reportItem->setEmployeeSurname($list['surname']);
            $reportItem->setDepartmentName($list['departmentName']);
            $reportItem->setBonusSalary($list['bonusSalary']);
            $reportItem->setSalaryBonusType($list['salaryBonusType']);
            $reportItem->setSalary($list['salary']);
            $reportItem->setDepartment($department);
            $reportItem->setEmployee($employee);
            $reportItem->setAuDate($list['auDate']);

            $this->_em->persist($reportItem);
            $counter++;
            if ($counter % $batchSize === 0) {
                $this->_em->flush();
            }
        }
        $this->_em->flush();
    }

    /**
     * @param FilterCriteria $filterCriteria
     * @return float|int|mixed|string
     */
    public function getSalaryReport(FilterCriteria $filterCriteria): array
    {
        $orderType = $filterCriteria->getOrderType() ?? 'ASC';
        $filterColumn = $filterCriteria->getFilterByColumn();
        $sortByColumn = $filterCriteria->getSortByColumn() ?? 'department';
        $filterPhrase = $filterCriteria->getFilterText() ?? '';
        $auDate = $filterCriteria->getAuDate();

        $result = $this->createQueryBuilder('qb')
            ->select('e.id')->distinct()
            ->addSelect('sr.employeeName')
            ->addSelect('sr.employeeSurname')
            ->addSelect('sr.departmentName')
            ->addSelect('sr.bonusSalary')
            ->addSelect('sr.salaryBonusType')
            ->addSelect('sr.salary')
            ->addSelect('sr.au_date')->distinct()
            ->from('App\Modules\Payments\Infrastructure\Entity\SalaryReport', 'sr')
            ->join('sr.employee', 'e')
            ->andWhere('sr.'.$filterColumn . ' LIKE :filterColumn')
            ->andWhere('sr.au_date = :auDate')
            ->setParameter('filterColumn', '%'.$filterPhrase.'%')
            ->setParameter('auDate', $auDate)
            ->groupBy('e.id, sr.employeeName, sr.employeeSurname, sr.departmentName, sr.bonusSalary, sr.salaryBonusType, sr.salary, sr.au_date')
            ->orderBy('sr.'.$sortByColumn, $orderType)
            ->getQuery()
            ->getResult()
            ;
        return !empty($result) ? $result : [];
    }
}

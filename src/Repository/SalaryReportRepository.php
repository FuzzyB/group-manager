<?php

namespace App\Repository;

use App\Entity\SalaryReport;
use App\Form\FilterCryteria;
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
    public function __construct(ManagerRegistry $registry)
    {
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

            $reportItem = new SalaryReport();
            //@todo avoid duplications in db, find record or create
            $reportItem->setEmployeeName($list['name']);
            $reportItem->setEmployeeSurname($list['surname']);
            $reportItem->setDepartmentName($list['departmentName']);
            $reportItem->setBonusSalary($list['bonusSalary']);
            $reportItem->setSalaryBonusType($list['salaryBonusType']);
            $reportItem->setSalary($list['salary']);
            $reportItem->setDepartment($list['department']);
            $reportItem->setEmployee($list['employee']);
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
     * @param FilterCryteria $filterCriteria
     * @return float|int|mixed|string
     */
    public function getSalaryReport(FilterCryteria $filterCriteria)
    {
        $orderType = $filterCriteria->getOrderType() ?? 'ASC';
        $filterColumn = $filterCriteria->getFilterByColumn();
        $sortByColumn = $filterCriteria->getSortByColumn() ?? 'department';
        $filterPhrase = $filterCriteria->getFilterText() ?? '';
        $auDate = $filterCriteria->getAuDate();

        return $this->createQueryBuilder('qb')
            ->select('e.id')->distinct()
            ->addSelect('sr.employeeName')
            ->addSelect('sr.employeeSurname')
            ->addSelect('sr.departmentName')
            ->addSelect('sr.bonusSalary')
            ->addSelect('sr.salaryBonusType')
            ->addSelect('sr.salary')
            ->addSelect('sr.au_date')->distinct()
            ->from('App\Entity\SalaryReport', 'sr')
            ->join('sr.employee', 'e')
            ->andWhere('sr.'.$filterColumn . ' LIKE :filterColumn')
            ->andWhere('sr.au_date = :auDate')
            ->setParameter('filterColumn', '%'.$filterPhrase.'%')
            ->setParameter('auDate', $auDate)
            ->groupBy('e.id, sr.employeeName, sr.employeeSurname, sr.departmentName, sr.bonusSalary, sr.salaryBonusType, sr.salary, sr.au_date')
            ->orderBy('sr.'.$sortByColumn, $orderType)
            ->orderBy('sr.au_date', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}

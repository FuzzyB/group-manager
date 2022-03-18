<?php

namespace App\Repository;

use App\Entity\SalaryReport;
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

    // /**
    //  * @return SalaryReport[] Returns an array of SalaryReport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SalaryReportemployee
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function saveSalaryList(array $salaryList)
    {
        $batchSize = 100;
        $counter = 0;

        foreach ($salaryList as $list) {
            $reportItem = new SalaryReport();
            $reportItem->setEmployeeName($list['name']);
            $reportItem->setEmployeeSurname($list['surname']);
            $reportItem->setDepartmentName($list['departmentName']);
            $reportItem->setBonusSalary($list['bonusSalary']);
            $reportItem->setSalaryBonusType($list['salaryBonusType']);
            $reportItem->setSalary($list['salary']);
            $reportItem->setDepartment($list['department']);
            $reportItem->setEmployee($list['employee']);

            $this->_em->persist($reportItem);
            $counter++;
            if ($counter % $batchSize === 0) {
                $this->_em->flush();
            }
        }
        $this->_em->flush();
        //@todo add controller for fetch data (pagination, filtering, sort)
        // i jeszcze wjebać w jakiś widok
    }
}

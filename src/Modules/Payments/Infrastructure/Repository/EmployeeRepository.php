<?php

namespace App\Modules\Payments\Infrastructure\Repository;

use App\Modules\Payments\Domain\Factory\EmployeeFactory;
use App\Modules\Payments\Domain\Interfaces\EmployeeRepositoryInterface;
use App\Modules\Payments\Infrastructure\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository implements EmployeeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @param Employee $entity
     * @param bool $flush
     * @return void
     */
    public function add(Employee $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Employee $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Employee $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param int $departmentId
     * @return array
     * @throws \Exception
     */
    public function getByDepartmentId(int $departmentId): array
    {
        $employees = $this->createQueryBuilder('e')
            ->andWhere('e.department = :id')
            ->setParameter('id', $departmentId)
            ->getQuery()
            ->getResult()
            ;
        $factory = new EmployeeFactory();
        $result = [];

        foreach ($employees as $employee) {
            $result[] = $factory->create($employee);
        }

        return $result;
    }
}

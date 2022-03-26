<?php

namespace App\Modules\Payments\Infrastructure\Repository;

use App\Modules\Payments\Domain\Factory\DepartmentFactory;
use App\Modules\Payments\Domain\Interfaces\DepartmentRepositoryInterface;
use App\Modules\Payments\Infrastructure\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Department|null find($id, $lockMode = null, $lockVersion = null)
 * @method Department|null findOneBy(array $criteria, array $orderBy = null)
 * @method Department[]    findAll()
 * @method Department[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentRepository extends ServiceEntityRepository implements DepartmentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    /**
     * @param Department $entity
     * @param bool $flush
     * @return void
     */
    public function add(Department $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Department $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Department $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $departments = $this->createQueryBuilder('d')
            ->getQuery()
            ->getResult();

        $domainDepartments = [];
        $factory = new DepartmentFactory();
        foreach ($departments as $department) {
            $domainDepartments[] = $factory->create($department);
        }

        return $domainDepartments;
    }
}

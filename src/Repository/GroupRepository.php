<?php

namespace App\Repository;

use App\Domain\Generators\GroupGenerator;
use App\Domain\RepositoryInterface;
use App\Domain\RepositoryTrait;
use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository implements RepositoryInterface
{
    use RepositoryTrait;

    /**
     * @var GroupGenerator
     */
    private $generator;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    // /**
    //  * @return Group[] Returns an array of Group objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Group
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param array $fields
     * @return Group
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addEntity(array $fields)
    {
        /**
         * @var Group $entity
         */
        $entity = $this->createEntityObject();
        $entity->setName(current($fields));
        $this->saveEntity($entity);
        return $entity;
    }

    /**
     * @param GroupGenerator $generator
     */
    public function setGenerator(GroupGenerator $generator): void
    {
        $this->generator = $generator;
    }

    /**
     * @return Group[]
     */
    public function findGroups()
    {
        return $this->createQueryBuilder('g')
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

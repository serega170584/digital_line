<?php

namespace App\Repository;

use App\Domain\RepositoryInterface;
use App\Domain\RepositoryTrait;
use App\Domain\TeamGenerator;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository implements RepositoryInterface
{
    use RepositoryTrait;

    /**
     * @var TeamGenerator
     */
    private $generator;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    // /**
    //  * @return Team[] Returns an array of Team objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param array $fields
     * @return Team
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addEntity(array $fields)
    {
        /**
         * @var Team $entity
         */
        $entity = $this->createEntityObject();
        $entity->setName(current($fields));
        next($fields);
        $entity->setTeamGroup(current($fields));
        $this->saveEntity($entity);
        return $entity;
    }

    /**
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addGeneratedRecords(): self
    {
        $records = $this->generator->getRecords();
        foreach ($records as $fields) {
            $this->addEntity($fields);
        }
        return $this;
    }

    /**
     * @param TeamGenerator $generator
     */
    public function setGenerator(TeamGenerator $generator): void
    {
        $this->generator = $generator;
    }
}

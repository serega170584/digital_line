<?php

namespace App\Repository;

use App\Domain\GroupGenerator;
use App\Domain\RepositoryInterface;
use App\Domain\RepositoryTrait;
use App\Entity\Group;
use App\Entity\Team;
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
    /**
     * @var TeamRepository
     */
    private $teamRepository;

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
        /**
         * @var Team $teamEntity
         */
        $teamEntity = $this->teamRepository->createEntityObject();
        $teamEntity->setName('test');
        $entity->addTeam($teamEntity);
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
     * @param TeamRepository $teamRepository
     */
    public function setTeamRepository(TeamRepository $teamRepository): void
    {
        $this->teamRepository = $teamRepository;
    }
}

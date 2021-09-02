<?php

namespace App\Repository;

use App\Domain\PlayGenerator;
use App\Domain\RepositoryInterface;
use App\Domain\RepositoryTrait;
use App\Entity\Play;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Play|null find($id, $lockMode = null, $lockVersion = null)
 * @method Play|null findOneBy(array $criteria, array $orderBy = null)
 * @method Play[]    findAll()
 * @method Play[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayRepository extends ServiceEntityRepository implements RepositoryInterface
{

    use RepositoryTrait;

    /**
     * @var PlayGenerator
     */
    private $generator;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Play::class);
    }

    // /**
    //  * @return Play[] Returns an array of Play objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Play
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function addEntity(array $fields)
    {
        /**
         * @var Play $entity
         */
        die('asd');
        $entity = $this->createEntityObject();
        $entity->setTeam(current($fields));
        next($fields);
        $entity->setOpponent(current($fields));
        next($fields);
        $entity->setStage(current($fields));
        next($fields);
        $entity->setScoredGoals(current($fields));
        next($fields);
        $entity->setLostGoals(current($fields));
        $this->saveEntity($entity);
        return $entity;
    }

    /**
     * @param PlayGenerator $generator
     */
    public function setGenerator(PlayGenerator $generator): void
    {
        $this->generator = $generator;
    }
}

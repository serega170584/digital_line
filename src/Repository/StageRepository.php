<?php

namespace App\Repository;

use App\Domain\Collections\StageArrayCollection;
use App\Domain\Generator\Generator;
use App\Domain\Repository\RepositoryInterface;
use App\Domain\Repository\RepositoryTrait;
use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Stage createEntityObject()
 */
class StageRepository extends ServiceEntityRepository implements RepositoryInterface
{
    use RepositoryTrait;

    /**
     * @var Generator
     */
    private $generator;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
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
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return StageArrayCollection
     */
    public function findAllArrayCollection(): StageArrayCollection
    {
        $collection = new StageArrayCollection();
        foreach ($this->findAll() as $stage) {
            $collection->add($stage);
        }
        return $collection;
    }

    /**
     * @param array $fields
     * @return Stage
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addEntity(array $fields)
    {
        /**
         * @var Stage $entity
         */
        $entity = $this->createEntityObject();
        $entity->setName(current($fields));
        next($fields);
        $entity->setIsPlayoff(current($fields));
        $this->saveEntity($entity);
        return $entity;
    }

    public function setGenerator(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }
}

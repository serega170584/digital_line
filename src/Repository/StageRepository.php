<?php

namespace App\Repository;

use App\Domain\collections\StageArrayCollection;
use App\Domain\Generators\Generator;
use App\Domain\RepositoryInterface;
use App\Domain\RepositoryTrait;
use App\Entity\Play;
use App\Entity\Stage;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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

    public function setGenerator(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return Stage[]
     */
    public function findPlayoffStages()
    {
        return $this->createQueryBuilder('s')
            ->innerJoin(Play::class, 'p', Join::WITH, 'p.stage = s.id')
            ->innerJoin(Team::class, 't', Join::WITH, 'p.team = t.id')
            ->andWhere('s.isPlayoff = 1')
            ->orderBy('s.id', 'ASC')
            ->addOrderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Stage[]
     */
    public function findResultStages()
    {
        return $this->createQueryBuilder('s')
            ->innerJoin(Play::class, 'p', Join::WITH, 'p.stage = s.id')
            ->innerJoin(Team::class, 't', Join::WITH, 'p.team = t.id')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Team[]
     */
    public function getResultTeams()
    {
        $teams = [];
        $stages = $this->findResultStages();
        foreach ($stages as $stage) {
            $stageTeams = [];
            foreach ($stage->getPlays() as $play) {
                if ($play->getScoredGoals() > $play->getLostGoals()) {
                    $team = $play->getTeam();
                    $pointStageTeams = $stageTeams[$team->getPoints()] ?? [];
                    if (!(in_array($team, $teams) || in_array($team, $pointStageTeams))) {
                        $stageTeams[$team->getPoints()][] = $team;
                    }
                } else {
                    $team = $play->getOpponent();
                    $pointStageTeams = $stageTeams[$team->getPoints()] ?? [];
                    if (!(in_array($team, $teams) || in_array($team, $pointStageTeams))) {
                        $stageTeams[$team->getPoints()][] = $team;
                    }
                }
            }
            krsort($stageTeams);
            $stageTeams = array_merge(...$stageTeams);
            $teams = array_merge($teams, $stageTeams);
        }
        return $teams;
    }
}

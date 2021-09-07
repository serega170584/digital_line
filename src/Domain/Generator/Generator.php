<?php


namespace App\Domain\Generator;

use App\Entity\Stage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

abstract class Generator
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var ObjectManager
     */
    private $fixturesManager;
    /**
     * @var ObjectManager|EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->manager = $entityManager;
    }

    /**
     * @param Stage $entityObject
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist($entityObject)
    {
        $this->manager->persist($entityObject);
    }

    abstract public function execute();

    /**
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function flush(): self
    {
        $this->manager->flush();
        return $this;
    }

    /**
     * @param ObjectManager $fixturesManager
     */
    public function setFixturesManager(ObjectManager $fixturesManager): void
    {
        $this->fixturesManager = $fixturesManager;
    }
}
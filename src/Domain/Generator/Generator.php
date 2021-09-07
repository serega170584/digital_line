<?php


namespace App\Domain\Generator;

use App\Domain\Repository\RepositoryInterface;
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
     * @var ObjectManager|EntityManagerInterface
     */
    protected $manager;
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    public function __construct(?EntityManagerInterface $entityManager)
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
     * @param EntityManagerInterface|ObjectManager $manager
     */
    public function setManager($manager): void
    {
        $this->manager = $manager;
    }

    /**
     * @param RepositoryInterface $repository
     */
    public function setRepository(RepositoryInterface $repository): void
    {
        $this->repository = $repository;
    }

    /**
     * @return RepositoryInterface
     */
    public function getRepository(): RepositoryInterface
    {
        return $this->repository;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

}
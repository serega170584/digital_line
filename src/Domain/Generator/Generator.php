<?php


namespace App\Domain\Generator;


use App\Entity\Stage;
use App\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManager;

abstract class Generator
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(RepositoryInterface $repository, EntityManager $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function createEntityObject(): Stage
    {
        return $this->repository->createEntityObject();
    }

    /**
     * @param Stage $entityObject
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist($entityObject)
    {
        $this->entityManager->persist($entityObject);
    }

    abstract public function execute();

    /**
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function flush(): self
    {
        $this->entityManager->flush();
        return $this;
    }
}
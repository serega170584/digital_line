<?php


namespace App\Domain\Generator;

use App\Entity\Stage;
use Doctrine\Persistence\ObjectManager;

abstract class Generator
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
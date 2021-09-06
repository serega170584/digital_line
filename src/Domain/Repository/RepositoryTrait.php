<?php


namespace App\Domain\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Trait RepositoryTrait
 * @package App\Domain
 * @property string _entityName
 * @method EntityManager|EntityManagerInterface getEntityManager()
 */
trait RepositoryTrait
{
    /**
     * @return mixed
     */
    function createEntityObject()
    {
        $entity = new $this->_entityName();
        return $entity;
    }

    /**
     * @param object $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveEntity(object $entity)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);
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
            $entity = $this->addEntity($fields);
        }
        return $this;
    }

}
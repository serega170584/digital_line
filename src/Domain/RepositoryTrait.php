<?php


namespace App\Domain;

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
     * @var Object[]
     */
    private $entities = [];

    /**
     * @return object
     */
    public function createEntityObject()
    {
        /**
         * @var object $entity
         */
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
            $this->entities[] = $entity;
        }
        return $this;
    }

    /**
     * @return Object[]
     */
    public function getEntities(): array
    {
        return $this->entities;
    }
}
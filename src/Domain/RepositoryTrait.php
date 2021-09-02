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
}
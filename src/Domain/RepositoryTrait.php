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
     * @return InitializedEntityInterface
     */
    public function createEntityObject()
    {
        /**
         * @var InitializedEntityInterface $entity
         */
        $entity = new $this->_entityName();
        return $entity;
    }

    /**
     * @param mixed ...$attributes
     * @return InitializedEntityInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addEntity(...$attributes)
    {
        $entity = $this->createEntityObject();
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);
        $entityManager->flush();
        return $entity;
    }
}
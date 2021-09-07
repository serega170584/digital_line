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
}
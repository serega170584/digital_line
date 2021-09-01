<?php


namespace App\Domain;

/**
 * Trait RepositoryTrait
 * @package App\Domain
 * @property string _entityName
 */
trait RepositoryTrait
{
    /**
     * @return InitializedEntityInterface
     */
    public function createEntity()
    {
        /**
         * @var InitializedEntityInterface $entity
         */
        $entity = (new $this->_entityName)();
        return $entity;
    }
}
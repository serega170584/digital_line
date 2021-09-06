<?php


namespace App\Domain\Repository;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface RepositoryInterface
 * @package App\Repository
 * @method createEntityObject()
 */
interface RepositoryInterface
{
    public function addEntity(array $fields);

    public function addGeneratedRecords();
}
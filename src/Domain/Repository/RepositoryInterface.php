<?php


namespace App\Domain\Repository;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface RepositoryInterface
 * @package App\Repository
 */
interface RepositoryInterface
{
    public function createEntityObject(array $fields);
}
<?php


namespace App\Domain\Generator;


use App\Domain\Repository\RepositoryInterface;
use App\Entity\Group;
use App\Entity\Play;
use App\Entity\Stage;
use App\Entity\Team;

/**
 * Trait GeneratorTrait
 * @package App\Domain\Generator
 * @property RepositoryInterface $repository
 */
trait GeneratorTrait
{
    /**
     * @return Stage|Group|Team|Play
     */
    public function createEntityObject()
    {
        return $this->repository->createEntityObject();
    }
}
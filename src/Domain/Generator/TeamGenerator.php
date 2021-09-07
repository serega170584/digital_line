<?php

namespace App\Domain\Generator;

use App\Repository\TeamRepository;

class TeamGenerator extends Generator
{
    use GeneratorTrait, TeamGeneratorTrait;

    /**
     * @var TeamRepository
     */
    private $repository;

    /**
     * @param TeamRepository $repository
     */
    public function setRepository(TeamRepository $repository): void
    {
        $this->repository = $repository;
    }

}
<?php

namespace App\Domain\Generator;

use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;

class TeamGenerator extends Generator
{
    use GeneratorTrait, TeamGeneratorTrait;

    /**
     * @var TeamRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, TeamRepository $teamRepository)
    {
        parent::__construct($entityManager);
        $this->repository = $teamRepository;
    }
}
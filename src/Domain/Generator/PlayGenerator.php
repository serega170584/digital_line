<?php

namespace App\Domain\Generator;

use App\Repository\PlayRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlayGenerator extends Generator
{
    use GeneratorTrait, PlayGeneratorTrait;

    private const GROUP_TEAMS_COUNT = 8;
    private const WINNER_POINTS_COUNT = 7;
    private const WINNERS_COUNT = 4;
    private const PAIR_COUNT = 2;

    /**
     * @var PlayRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, PlayRepository $playRepository)
    {
        parent::__construct($entityManager);
        $this->repository = $playRepository;
    }
}
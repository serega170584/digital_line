<?php


namespace App\Domain\Tournaments;


use App\Repository\StageRepository;

class PlayoffTournament extends Tournament
{
    /**
     * @var StageRepository $repository
     */
    protected $repository;

    public function __construct(StageRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getUnits()
    {
        return $this->repository->findPlayoffStages();
    }

    public function getWinners()
    {
        // TODO: Implement getWinners() method.
    }
}
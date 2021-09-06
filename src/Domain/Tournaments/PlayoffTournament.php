<?php


namespace App\Domain\Tournaments;


use App\Domain\Collection\StageArrayCollection;
use App\Repository\StageRepository;

class PlayoffTournament implements TournamentInterface
{
    /**
     * @var StageRepository $repository
     */
    protected $repository;

    public function getUnits()
    {
        return $this->repository->findPlayoffStages();
    }

    public function getWinners()
    {
        // TODO: Implement getWinners() method.
    }

    public function build()
    {
        // TODO: Implement build() method.
    }

    /**
     * @param StageArrayCollection $stages
     */
    public function setStages(StageArrayCollection $stages): void
    {
        $this->stage = $stages;
    }
}
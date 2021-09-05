<?php


namespace App\Domain\Tournaments;


use App\Repository\StageRepository;

class PlayoffTournament extends Tournament
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
}
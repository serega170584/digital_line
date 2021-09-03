<?php


namespace App\Domain\Tournaments;


use App\Repository\StageRepository;

class PlayoffTournament extends Tournament
{
    public function __construct(StageRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getUnits()
    {
        return [];
    }

    public function getWinners()
    {
        // TODO: Implement getWinners() method.
    }
}
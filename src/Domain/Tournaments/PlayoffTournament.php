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
    /**
     * @var StageArrayCollection
     */
    private $stages;

    public function build()
    {
        // TODO: Implement build() method.
    }

    /**
     * @param StageArrayCollection $stages
     */
    public function setStages(StageArrayCollection $stages): void
    {
        $this->stages = $stages;
    }
}
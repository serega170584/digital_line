<?php


namespace App\Domain\Tournaments;


use App\Repository\StageRepository;

class CupTournament extends Tournament
{
    /**
     * @var StageRepository
     */
    private $stageRepository;
    /**
     * @var GroupTournament
     */
    private $groupTournament;
    /**
     * @var PlayoffTournament
     */
    private $playoffTournament;

    public function __construct(StageRepository $stageRepository, GroupTournament $groupTournament, PlayoffTournament $playoffTournament)
    {
        $this->groupTournament = $groupTournament;
        $this->playoffTournament = $playoffTournament;
        $this->stageRepository = $stageRepository;
    }

    public function getUnits()
    {
        return [];
    }

    public function getWinners()
    {
        return [];
    }

    public function build()
    {
        $stages = $this->stageRepository
            ->findAllArrayCollection();
        $groupStages = $stages->findIsGroup();
        var_dump($groupStages->count());
    }
}
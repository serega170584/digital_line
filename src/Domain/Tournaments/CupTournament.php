<?php


namespace App\Domain\Tournaments;


use App\Entity\Play;
use App\Entity\Team;
use App\Repository\StageRepository;

class CupTournament implements TournamentInterface
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
        $playoffStages = $stages->findIsPlayoff();
        $this->playoffTournament->setStages($playoffStages);
        $this->playoffTournament->build();
        $groupStage = $stages->findIsGroup()->first();
        $this->groupTournament->setStage($groupStage);
        $this->groupTournament->setPlayoffStages($playoffStages);
        $this->groupTournament->build();
    }

    /**
     * @return GroupTournament
     */
    public function getGroupTournament(): GroupTournament
    {
        return $this->groupTournament;
    }

    /**
     * @param Team $team
     * @return Play[]
     */
    public function findTeamGroupPlays(Team $team)
    {
        return $this->getGroupTournament()->findTeamPlays($team);
    }
}
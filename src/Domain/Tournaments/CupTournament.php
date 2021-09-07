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
    /**
     * @var Team[]
     */
    private $table;

    public function __construct(StageRepository $stageRepository, GroupTournament $groupTournament, PlayoffTournament $playoffTournament)
    {
        $this->groupTournament = $groupTournament;
        $this->playoffTournament = $playoffTournament;
        $this->stageRepository = $stageRepository;
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
        $this->buildTable();
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

    /**
     * @return PlayoffTournament
     */
    public function getPlayoffTournament(): PlayoffTournament
    {
        return $this->playoffTournament;
    }

    /**
     * @return $this
     */
    public function buildTable(): self
    {
        $this->table = array_merge($this->playoffTournament->getTable(),
            $this->groupTournament->getTable());
        return $this;
    }

    /**
     * @return Team[]
     */
    public function getTable(): array
    {
        return $this->table;
    }
}
<?php


namespace App\Domain\Tournaments;


use App\Domain\Collection\StageArrayCollection;
use App\Entity\Play;
use App\Entity\Stage;
use App\Entity\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class GroupTournament implements TournamentInterface
{
    const WINNERS_COUNT = 4;
    const ID = 'id';

    /**
     * @var StageArrayCollection
     */
    private $playoffStages;
    /**
     * @var ArrayCollection
     */
    private $groups;
    /**
     * @var Stage
     */
    private $stage;

    /**
     * @return Team[]
     */
    public function getWinners()
    {
        $winners = [];
        foreach ($this->repository->findGroups() as $group) {
            $groupWinners = $group->getTeams()->slice(0, self::WINNERS_COUNT);
            $winners = array_merge($winners, $groupWinners);
        }
        return $winners;
    }


    public function build()
    {
        /**
         * @var Stage $stage
         */
        $stage = $this->playoffStages->matching(Criteria::create()
            ->orderBy([self::ID => Criteria::ASC]))
            ->first();
        /**
         * @var Play $play
         */
        $play = $stage->getPlays()->first();
        $this->groups = new ArrayCollection([
            $play->getTeam()->getTeamGroup(),
            $play->getOpponent()->getTeamGroup()
        ]);
    }

    /**
     * @param StageArrayCollection $playoffStages
     */
    public function setPlayoffStages(StageArrayCollection $playoffStages): void
    {
        $this->playoffStages = $playoffStages;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups(): ArrayCollection
    {
        return $this->groups;
    }

    /**
     * @param Stage $stage
     */
    public function setStage(Stage $stage): void
    {
        $this->stage = $stage;
    }

    /**
     * @param Team $team
     * @return mixed
     */
    public function findTeamPlays(Team $team)
    {
        return $this->stage->getPlays()->matching(Criteria::create()
            ->where(Criteria::expr()->eq('team', $team))
            ->orderBy([self::ID => Criteria::ASC]));
    }
}
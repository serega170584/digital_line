<?php


namespace App\Domain\Tournaments;


use App\Domain\Collections\StageArrayCollection;
use App\Entity\Group;
use App\Entity\Play;
use App\Entity\Stage;
use App\Entity\Team;
use Doctrine\Common\Collections\Criteria;

class GroupTournament extends Tournament
{
    const WINNERS_COUNT = 4;
    const ID = 'id';

    /**
     * @var StageArrayCollection
     */
    private $playoffStages;

    /**
     * @return Group[]
     */
    public function getUnits()
    {
        $group = current($this->repository->findGroups());
        return $this->repository->findGroups();
    }

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
            ->current();
        $play = $stage->getPlays()->current();
        var_dump($play->getTeam()->getTeamGroup()->getId());
        var_dump($play->getOpponent()->getTeamGroup()->getId());
    }

    /**
     * @param StageArrayCollection $playoffStages
     */
    public function setPlayoffStages(StageArrayCollection $playoffStages): void
    {
        $this->playoffStages = $playoffStages;
    }
}
<?php


namespace App\Domain\Tournaments;


use App\Entity\Group;
use App\Entity\Team;

class GroupTournament extends Tournament
{
    const WINNERS_COUNT = 4;

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
        // TODO: Implement build() method.
    }
}
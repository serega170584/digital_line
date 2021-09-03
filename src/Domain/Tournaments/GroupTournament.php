<?php


namespace App\Domain\Tournaments;


use App\Entity\Group;
use App\Entity\Team;
use App\Repository\GroupRepository;

class GroupTournament extends Tournament
{
    const WINNERS_COUNT = 4;
    /**
     * @var GroupRepository $repository
     */
    protected $repository;

    public function __construct(GroupRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @return Group[]
     */
    public function getUnits()
    {
        $group= current($this->repository->findGroups());
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
}
<?php


namespace App\Domain;


use App\Repository\GroupRepository;

class TeamGenerator extends Generator
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        parent::__construct();
        $this->groupRepository = $groupRepository;
    }

    public function generate(): self
    {
        $groups = $this->groupRepository->findAll();
        $teams = [
            ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'],
            ['I', 'J', 'K', 'L', 'M', 'N', 'O', 'P']
        ];
        foreach ($groups as $group) {
            $groupTeams = current($teams);
            foreach ($groupTeams as $key => $team) {
                $this->records = [$team, $group];
            }
            next($teams);
        }
        return $this;
    }
}
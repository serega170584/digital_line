<?php


namespace App\Domain\Generators;


use App\Repository\GroupRepository;

class TeamGeneratorInterface extends GeneratorInterface
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

    public function execute(): self
    {
        $groups = $this->groupRepository->getEntities();
        $teams = [
            ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'],
            ['I', 'J', 'K', 'L', 'M', 'N', 'O', 'P']
        ];
        foreach ($groups as $group) {
            $groupTeams = current($teams);
            foreach ($groupTeams as $key => $team) {
                $this->records[] = [$team, $group];
            }
            next($teams);
        }
        return $this;
    }
}
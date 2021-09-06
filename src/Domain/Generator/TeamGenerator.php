<?php


namespace App\Domain\Generator;


use App\Entity\Group;
use App\Entity\Team;

class TeamGenerator extends Generator
{

    /**
     * @var Group[]
     */
    private $groups;
    /**
     * @var Team[]
     */
    private $teams;

    public function execute(): self
    {
        $groups = $this->groups;
        $teams = [
            ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'],
            ['I', 'J', 'K', 'L', 'M', 'N', 'O', 'P']
        ];
        foreach ($groups as $group) {
            $groupTeams = current($teams);
            foreach ($groupTeams as $name) {
                $entityObject = $this->createEntityObject();
                $entityObject->setName($name);
                $entityObject->setTeamGroup($group);
                $this->teams[] = $entityObject;
                $this->persist($entityObject);
            }
            next($teams);
        }
        return $this;
    }

    /**
     * @param Group[] $groups
     */
    public function setGroups(array $groups): void
    {
        $this->groups = $groups;
    }

    /**
     * @return array
     */
    public function getTeams(): array
    {
        return $this->teams;
    }
}
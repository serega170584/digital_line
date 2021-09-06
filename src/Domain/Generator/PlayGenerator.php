<?php


namespace App\Domain\Generator;


use App\Entity\Stage;
use App\Entity\Team;

class PlayGenerator extends Generator
{
    private const GROUP_TEAMS_COUNT = 8;
    private const WINNER_POINTS_COUNT = 7;
    /**
     * @var Stage[]
     */
    private $stages;

    /**
     * @var Team[] $teams
     */
    private $teams;

    public function execute(): self
    {
        $this->inflateGroup(0, self::WINNER_POINTS_COUNT);
        $this->inflateGroup(self::WINNER_POINTS_COUNT, self::WINNER_POINTS_COUNT * 2 - 1);
        return $this;
    }

    public function inflateGroup($fromTeamIndex, $toTeamIndex): self
    {
        $stages = $this->stages;
        $stage = current($stages);
        $teams = $this->teams;
        $points = self::WINNER_POINTS_COUNT;
        for ($i = 0; $i < self::GROUP_TEAMS_COUNT; ++$i) {
            for ($j = 0; $j < self::GROUP_TEAMS_COUNT; ++$j) {
                $entityObject = $this->createEntityObject();
                $entityObject->setTeam($teams[$i]);
                $entityObject->setOpponent($teams[$j]);
                if ($i == $j) {
                    $entityObject->setScoredGoals(0);
                    $entityObject->setLostGoals(0);
                } elseif ($i > $j) {
                    $entityObject->setScoredGoals(0);
                    $entityObject->setLostGoals(1);
                } else {
                    $entityObject->setScoredGoals(1);
                    $entityObject->setLostGoals(0);
                }
                $this->persist($entityObject);
            }
            $team = $teams[$i];
            $team->setPoints($points);
            $this->persist($team);
            --$points;
        }
        return $this;
    }

    /**
     * @param Stage[] $stages
     */
    public function setStages(array $stages): void
    {
        $this->stages = $stages;
    }

    /**
     * @param Team[] $teams
     */
    public function setTeams(array $teams): void
    {
        $this->teams = $teams;
    }
}
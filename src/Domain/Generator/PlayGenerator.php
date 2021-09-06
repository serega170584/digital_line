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
        $this->inflateGroup(0, self::GROUP_TEAMS_COUNT);
        $this->inflateGroup(self::GROUP_TEAMS_COUNT, self::GROUP_TEAMS_COUNT * 2);
        return $this;
    }

    public function inflateGroup($fromTeamIndex, $toTeamIndex): self
    {
        $stages = $this->stages;
        $stage = current($stages);
        $teams = $this->teams;
        $points = self::WINNER_POINTS_COUNT;
        for ($i = $fromTeamIndex; $i < $toTeamIndex; ++$i) {
            for ($j = $fromTeamIndex; $j < $toTeamIndex; ++$j) {
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
                $entityObject->setStage($stage);
                $this->persist($entityObject);
            }
            /**
             * @var Team $team
             */
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
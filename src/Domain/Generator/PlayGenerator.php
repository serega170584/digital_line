<?php


namespace App\Domain\Generator;


use App\Entity\Stage;
use App\Entity\Team;

class PlayGenerator extends Generator
{
    private const GROUP_TEAMS_COUNT = 8;
    private const WINNER_POINTS_COUNT = 7;
    private const WINNERS_COUNT = 4;
    private const DEFAULT_STAGE_ORDER = 1;
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
        $this->inflatePlayoff();
        return $this;
    }

    public function inflateGroup($fromTeamIndex, $toTeamIndex): self
    {
        $stages = $this->stages;
        $stage = current($stages);
        $teams = $this->teams;
        $points = self::WINNER_POINTS_COUNT;
        $stageOrder = 0;
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
                $entityObject->setStageOrder($stageOrder);
                ++$stageOrder;
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

    public function inflatePlayoff(): self
    {
        $stage = next($this->stages);
        $teams = $this->teams;
        $groupTeams = array_slice($teams, 0, self::WINNERS_COUNT);
        $opponents = array_reverse(array_slice($teams, self::GROUP_TEAMS_COUNT, self::WINNERS_COUNT));
        $orderedTeams = [];
        $shift = 0;
        for ($i = 0; $i < self::WINNERS_COUNT; ++$i) {
            $entityObject = $this->createEntityObject();
            $entityObject->setTeam($groupTeams[$i]);
            $entityObject->setOpponent($opponents[$i]);
            $entityObject->setScoredGoals(1);
            $entityObject->setLostGoals(0);
            $stageOrder = ($i % 2) * self::WINNERS_COUNT / 2 + $shift;
            $shift += ($i % 2);
            $orderedTeams[$stageOrder] = $groupTeams[$i];
            $entityObject->setStageOrder($stageOrder + 1);
            $entityObject->setStage($stage);
            $this->persist($entityObject);
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
<?php


namespace App\Domain\Generator;


use App\Entity\Stage;
use App\Entity\Team;

class PlayGenerator extends Generator
{
    private const GROUP_TEAMS_COUNT = 8;
    private const WINNER_POINTS_COUNT = 7;
    private const WINNERS_COUNT = 4;
    private const PAIR_COUNT = 2;

    /**
     * @var Stage[]
     */
    private $stages;

    /**
     * @var Team[] $teams
     */
    private $teams;
    /**
     * @var Team[]
     */
    private $orderedTeams;

    public function execute(): self
    {
        $this->inflateGroup(0, self::GROUP_TEAMS_COUNT);
        $this->inflateGroup(self::GROUP_TEAMS_COUNT, self::GROUP_TEAMS_COUNT * 2);
        $this->inflatePlayoff();
        return $this;
    }

    private function inflateGroup($fromTeamIndex, $toTeamIndex): self
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

    private function inflatePlayoff(): self
    {
        next($this->stages);
        $teams = $this->teams;
        $groupTeams = array_slice($teams, 0, self::WINNERS_COUNT);
        $opponents = array_reverse(array_slice($teams, self::GROUP_TEAMS_COUNT, self::WINNERS_COUNT));
        $this->orderedTeams = [];
        $shift = 0;
        for ($i = 0; $i < self::WINNERS_COUNT; ++$i) {
            $this->inflatePlayoffPlay($groupTeams[$i], $opponents[$i], $i, self::WINNERS_COUNT, $shift);
            $shift += ($i % 2);
        }
        $stage = next($this->stages);
        while ($stage) {
            $playOrder = 0;
            $teams = $this->orderedTeams;
            $winnersCount = count($teams);
            $this->orderedTeams = [];
            ksort($teams);
            $pair = array_slice($teams, $playOrder * 2, self::PAIR_COUNT);
            $shift = 0;
            while ($pair) {
                $team = $pair[0];
                $opponent = $pair[1];
                $this->inflatePlayoffPlay($team, $opponent, $playOrder, $winnersCount, $shift);
                ++$playOrder;
                $shift += ($playOrder % 2);
                $pair = array_slice($teams, $playOrder * 2, self::PAIR_COUNT);
            }
            $stage = next($this->stages);
        }
        return $this;
    }

    private function inflatePlayoffPlay($team, $opponent, $playOrder, $winnersCount, $shift): self
    {
        $stage = current($this->stages);
        $entityObject = $this->createEntityObject();
        $entityObject->setTeam($team);
        $entityObject->setOpponent($opponent);
        $entityObject->setScoredGoals(1);
        $entityObject->setLostGoals(0);
        $stageOrder = ($playOrder % 2) * $winnersCount / 2 + $shift;
        $this->orderedTeams[$stageOrder] = $team;
        $entityObject->setStageOrder($stageOrder + 1);
        $entityObject->setStage($stage);
        $this->persist($entityObject);
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
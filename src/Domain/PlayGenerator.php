<?php


namespace App\Domain;


use App\Repository\GroupRepository;
use App\Repository\StageRepository;

class PlayGenerator extends Generator
{
    private const GROUP_TEAMS_COUNT = 8;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var StageRepository
     */
    private $stageRepository;

    public function __construct(GroupRepository $groupRepository, StageRepository $stageRepository)
    {
        parent::__construct();
        $this->groupRepository = $groupRepository;
        $this->stageRepository = $stageRepository;
    }

    public function generate()
    {
        $groups = $this->groupRepository->findAll();
        $stage = $this->stageRepository->findPreliminaryRound();
        $goals = [];
        for ($i = 0; $i < self::GROUP_TEAMS_COUNT; ++$i) {
            $goals[] = [1, 0];
        }
        var_dump($groups->count());
        var_dump($stage->getName());
        foreach ($groups as $group) {
            $teams = $group->getTeams();
            $opponentsTeams = $teams;
            var_dump($teams->count());
            var_dump($opponentsTeams->count());
            $groupGoals = $goals;
            $currentTeamIndex = 0;
            foreach ($teams as $team) {
                reset($groupGoals);
                $groupGoals[$currentTeamIndex] = [0, 0];
                if ($currentTeamIndex) {
                    $groupGoals[$currentTeamIndex - 1] = [0, 1];
                }
                foreach ($opponentsTeams as $opponentTeam) {
                    $playGoals = current($groupGoals);
                    $teamGoals = current($playGoals);
                    next($playGoals);
                    $opponentGoals = current($playGoals);
                    $this->records[] = [$team, $opponentTeam, $stage, $teamGoals, $opponentGoals];
                    next($groupGoals);
                }
                ++$currentTeamIndex;
            }
        }
        return $this;
    }
}
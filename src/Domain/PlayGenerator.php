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
        foreach ($groups as $group) {
            $teams = $group->getTeams();
            $opponentsTeams = $teams;
            $groupGoals = $goals;
            $currentTeamIndex = 0;
            foreach ($teams as $team) {
                $groupGoals[$currentTeamIndex] = [0, 0];
                if ($currentTeamIndex) {
                    $groupGoals[$currentTeamIndex - 1] = [0, 1];
                }
                foreach ($opponentsTeams as $opponentTeam) {
                    $playGoals = current($groupGoals);
                    $teamGoals = current($playGoals);
                    var_dump($teamGoals);
                    next($playGoals);
                    $opponentGoals = current($playGoals);
                    var_dump($opponentGoals);
                    $this->records[] = [$team, $opponentTeam, $stage, $teamGoals, $opponentGoals];
                    next($groupGoals);
                }
            }
        }
//        var_dump($this->records);
        die('asd');
        return $this;
    }
}
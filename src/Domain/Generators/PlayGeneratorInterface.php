<?php


namespace App\Domain\Generators;


use App\Repository\GroupRepository;
use App\Repository\StageRepository;

class PlayGeneratorInterface
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

    public function execute(): self
    {
        $groups = $this->groupRepository->getEntities();
        $stage = current($this->stageRepository->getEntities());
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
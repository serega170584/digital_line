<?php


namespace App\Domain;


use App\Repository\GroupRepository;
use App\Repository\StageRepository;

class PlayGenerator extends Generator
{
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
        $stages = $this->stageRepository->findOneBy(['isPlayoff' => false]);
        foreach ($groups as $group) {
            $teams = $group->getTeams();
            $opponentsTeams = $teams;
            foreach ($teams as $team) {
                foreach ($opponentsTeams as $opponentTeam) {

                }
            }
        }

        return $this;
    }
}
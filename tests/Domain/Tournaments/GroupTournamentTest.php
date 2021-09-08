<?php

namespace App\Tests\Service;

use App\Domain\Tournaments\GroupTournament;
use App\Entity\Play;
use App\Repository\StageRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GroupTournamentTest extends KernelTestCase
{
    public function testBuild()
    {
        self::bootKernel();
        $container = static::getContainer();
        /**
         * @var StageRepository $stageRepository
         */
        $stageRepository = $container->get(StageRepository::class);
        $playoffStages = $stageRepository->findAllArrayCollection()->findIsPlayoff();
        /**
         * @var GroupTournament $groupTournament
         */
        $groupTournament = $container->get(GroupTournament::class);
        $groupTournament->setPlayoffStages($playoffStages);
        $groupTournament->build();
        /**
         * @var TeamRepository $teamRepository
         */
        $teamRepository = $container->get(TeamRepository::class);
        $teams = $teamRepository->findAll();
        $team = current($teams);
        $plays = $groupTournament->findTeamPlays($team);
        $teamNames = $plays->map(function (Play $play) {
            return $play->getTeam()->getName();
        });
        $this->assertEquals(['A', 'A', 'A', 'A', 'A', 'A', 'A', 'A'], $teamNames->toArray());
        $opponentNames = $plays->map(function (Play $play) {
            return $play->getOpponent()->getName();
        });
        $this->assertEquals(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'], $opponentNames->toArray());
        $scoredGoals = $plays->map(function (Play $play) {
            return $play->getScoredGoals();
        });
        $this->assertEquals([0, 1, 1, 1, 1, 1, 1, 1], $scoredGoals->toArray());
        $lostGoals = $plays->map(function (Play $play) {
            return $play->getLostGoals();
        });
        $this->assertEquals([0, 0, 0, 0, 0, 0, 0, 0], $lostGoals->toArray());
    }
}

<?php

namespace App\Tests\Service;

use App\Domain\Tournaments\PlayoffTournament;
use App\Entity\Play;
use App\Entity\Stage;
use App\Entity\Team;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlayoffTournamentTest extends KernelTestCase
{
    public function testBuild()
    {
        self::bootKernel();
        $container = static::getContainer();
        /**
         * @var StageRepository $stageRepository
         */
        $stageRepository = $container->get(StageRepository::class);
        $stages = $stageRepository->findAllArrayCollection();
        $playoffStages = $stages->findIsPlayoff();
        /**
         * @var PlayoffTournament $playoffTournament
         */
        $playoffTournament = $container->get(PlayoffTournament::class);
        $playoffTournament->setStages($playoffStages);
        $playoffTournament->build();

        $stages = $playoffTournament->getStages();
        /**
         * @var Stage $stage
         */
        $stage = $stages->current();
        $this->assertEquals('1/4', $stage->getName());
        $plays = $stage->getOrderedPlays();
        $teams = $plays->map(function (Play $play) {
            return $play->getTeam()->getName();
        });
        $this->assertEquals(['A', 'C', 'B', 'D'], array_values($teams->toArray()));
        $opponents = $plays->map(function (Play $play) {
            return $play->getOpponent()->getName();
        });
        $this->assertEquals(['L', 'J', 'K', 'I'], array_values($opponents->toArray()));
        $scoredGoals = $plays->map(function (Play $play) {
            return $play->getScoredGoals();
        });
        $this->assertEquals([1, 1, 1, 1], array_values($scoredGoals->toArray()));
        $lostGoals = $plays->map(function (Play $play) {
            return $play->getLostGoals();
        });
        $this->assertEquals([0, 0, 0, 0], array_values($lostGoals->toArray()));

        $stage = $stages->next();
        $this->assertEquals('1/2', $stage->getName());
        $plays = $stage->getOrderedPlays();
        $teams = $plays->map(function (Play $play) {
            return $play->getTeam()->getName();
        });
        $this->assertEquals(['A', 'B'], array_values($teams->toArray()));
        $opponents = $plays->map(function (Play $play) {
            return $play->getOpponent()->getName();
        });
        $this->assertEquals(['C', 'D'], array_values($opponents->toArray()));
        $scoredGoals = $plays->map(function (Play $play) {
            return $play->getScoredGoals();
        });
        $this->assertEquals([1, 1], array_values($scoredGoals->toArray()));
        $lostGoals = $plays->map(function (Play $play) {
            return $play->getLostGoals();
        });
        $this->assertEquals([0, 0], array_values($lostGoals->toArray()));

        $stage = $stages->next();
        $this->assertEquals('Final', $stage->getName());
        $plays = $stage->getOrderedPlays();
        $teams = $plays->map(function (Play $play) {
            return $play->getTeam()->getName();
        });
        $this->assertEquals(['A'], array_values($teams->toArray()));
        $opponents = $plays->map(function (Play $play) {
            return $play->getOpponent()->getName();
        });
        $this->assertEquals(['B'], array_values($opponents->toArray()));
        $scoredGoals = $plays->map(function (Play $play) {
            return $play->getScoredGoals();
        });
        $this->assertEquals([1], array_values($scoredGoals->toArray()));
        $lostGoals = $plays->map(function (Play $play) {
            return $play->getLostGoals();
        });
        $this->assertEquals([0], array_values($lostGoals->toArray()));
        $this->assertEmpty($stages->next());

        $playoffTournament->buildTable();
        $table = $playoffTournament->getTable();
        $teams = array_map(function (Team $team) {
            return $team->getName();
        }, $table);
        $this->assertEquals([
            'A', 'B', 'C', 'D',
            'I', 'J', 'K', 'L'
        ], array_values($teams));
    }
}

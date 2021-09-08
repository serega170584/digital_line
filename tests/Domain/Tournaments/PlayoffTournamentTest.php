<?php

namespace App\Tests\Service;

use App\Domain\Tournaments\PlayoffTournament;
use App\Entity\Play;
use App\Entity\Stage;
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
    }
}

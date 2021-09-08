<?php

namespace App\Tests\Service;

use App\Domain\Tournaments\CupTournament;
use App\Entity\Play;
use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CupTournamentTest extends KernelTestCase
{
    public function testBuild()
    {
        self::bootKernel();
        $container = static::getContainer();
        /**
         * @var CupTournament $cupTournament
         */
        $cupTournament = $container->get(CupTournament::class);
        $cupTournament->build();
        /**
         * @var TeamRepository $teamRepository
         */
        $teamRepository = $container->get(TeamRepository::class);
        /**
         * @var Team[] $teams
         */
        $teams = $teamRepository->findAll();
        $team = current($teams);
        $plays = $cupTournament->findTeamGroupPlays($team);
        $teamNames = $plays->map(function (Play $play) {
            return $play->getTeam()->getName();
        });
        $this->assertEquals(['A', 'A', 'A', 'A', 'A', 'A', 'A', 'A'], $teamNames->toArray());
        $opponentNames = $plays->map(function (Play $play) {
            return $play->getOpponent()->getName();
        });
        $this->assertEquals(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'], $opponentNames->toArray());
    }
}

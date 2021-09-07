<?php

namespace App\Tests\Service;


use App\Entity\Team;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TeamGeneratorTest extends KernelTestCase
{
    const ID = 'id';

    public function testGenerate()
    {
        self::bootKernel();
        $container = static::getContainer();
        /**
         * @var TeamRepository $stageRepository
         */
        $teamRepository = $container->get(TeamRepository::class);

        /**
         * @var Team[] $stages
         */
        $teams = $teamRepository->findBy([], [self::ID => Criteria::ASC]);
        $names = array_map(function (Team $team) {
            return $team->getName();
        }, $teams);
        $this->assertEqualsCanonicalizing($names, [
            'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H',
            'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P'
        ]);
    }
}

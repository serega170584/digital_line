<?php

namespace App\Tests\Service;


use App\Repository\PlayRepository;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlayGeneratorTest extends KernelTestCase
{
    public function testGenerate()
    {
        self::bootKernel();
        $container = static::getContainer();
        /**
         * @var PlayRepository $playRepository
         */
        $playRepository = $container->get(PlayRepository::class);
        $this->assertEquals($playRepository->count([]), 135);

        $stageTeamCounts = [];
        /**
         * @var StageRepository $stageRepository
         */
        $stageRepository = $container->get(StageRepository::class);
        $stages = $stageRepository->findAll();
        $stage = current($stages);
        $stageTeamCounts[] = $stage->getPlays()->count();
        $stage = current($stages);
        $stageTeamCounts[] = $stage->getPlays()->count();
        $stage = current($stages);
        $stageTeamCounts[] = $stage->getPlays()->count();
        $stage = current($stages);
        $stageTeamCounts[] = $stage->getPlays()->count();
        var_dump($stageTeamCounts);
        die('asd');
        $this->assertEqualsCanonicalizing($stageTeamCounts, [135, 4, 2, 1]);
    }
}

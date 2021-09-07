<?php

namespace App\Tests\Service;


use App\Entity\Stage;
use App\Entity\Team;
use App\Repository\PlayRepository;
use App\Repository\StageRepository;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

const TEAM = 'team';

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
        $stage = next($stages);
        $stageTeamCounts[] = $stage->getPlays()->count();
        $stage = next($stages);
        $stageTeamCounts[] = $stage->getPlays()->count();
        $stage = next($stages);
        $stageTeamCounts[] = $stage->getPlays()->count();
        $this->assertEqualsCanonicalizing($stageTeamCounts, [128, 4, 2, 1]);

        reset($stages);
        $groupStages = array_unique(array_map(function (Stage $stage) {
            $res = !($stage->getIsPlayoff()) ? $stage : false;
            return $res;
        }, $stages));

        /**
         * @var Stage $groupStage
         */
        $groupStage = current($groupStages);
        /**
         * @var TeamRepository $teamRepository
         */
        $teamRepository = $container->get(TeamRepository::class);
        $teams = $teamRepository->findAll();
        array_map(function (Team $team) use ($groupStage) {
            $groupPlaysCount = $groupStage->getPlays()->matching(Criteria::create()
                ->where(Criteria::expr()->eq(TEAM, $team)))
                ->count();
            $this->assertEquals(8, $groupPlaysCount);
        }, $teams);
    }
}

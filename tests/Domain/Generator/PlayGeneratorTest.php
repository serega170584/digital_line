<?php

namespace App\Tests\Service;


use App\Entity\Play;
use App\Entity\Stage;
use App\Entity\Team;
use App\Repository\PlayRepository;
use App\Repository\StageRepository;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class PlayGeneratorTest extends KernelTestCase
{
    const IS_PLAYOFF = 'isPlayoff';
    const TEAM = 'team';
    const OPPONENT = 'opponent';
    const ID = 'id';
    const STAGE_ORDER = 'stageOrder';

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
        $stages = new ArrayCollection($stages);
        $groupStages = $stages->matching(Criteria::create()
            ->where(Criteria::expr()->eq(self::IS_PLAYOFF, false)));

        /**
         * @var Stage $groupStage
         */
        $groupStage = $groupStages->current();
        /**
         * @var TeamRepository $teamRepository
         */
        $teamRepository = $container->get(TeamRepository::class);
        $teams = $teamRepository->findAll();
        array_map(function (Team $team) use ($groupStage) {
            $groupPlaysCount = $groupStage->getPlays()->matching(Criteria::create()
                ->where(Criteria::expr()->eq(self::TEAM, $team)))
                ->count();
            $this->assertEquals(8, $groupPlaysCount);
        }, $teams);

        array_map(function (Team $team) use ($groupStage) {
            $groupPlaysCount = $groupStage->getPlays()->matching(Criteria::create()
                ->where(Criteria::expr()->eq(self::OPPONENT, $team)))
                ->count();
            $this->assertEquals(8, $groupPlaysCount);
        }, $teams);

        $playoffStages = $stages->matching(Criteria::create()
            ->where(Criteria::expr()->eq(self::IS_PLAYOFF, true))
            ->orderBy([self::ID => Criteria::ASC]));

        /**
         * @var Stage $stage
         */
        $stage = $playoffStages->current();
        $names = $stage->getPlays()
            ->matching(Criteria::create()
                ->orderBy([self::STAGE_ORDER => Criteria::ASC]))
            ->map(function (Play $play) {
                return $play->getTeam()->getName();
            });
        $this->assertEquals([
            'A', 'C', 'B', 'D'
        ], array_values($names->toArray()));

        $names = $stage->getPlays()
            ->matching(Criteria::create()
                ->orderBy([self::STAGE_ORDER => Criteria::ASC]))
            ->map(function (Play $play) {
                return $play->getOpponent()->getName();
            });
        $this->assertEquals([
            'L', 'J', 'K', 'I'
        ], array_values($names->toArray()));

        $stage = $playoffStages->next();
        $names = $stage->getPlays()
            ->matching(Criteria::create()
                ->orderBy([self::STAGE_ORDER => Criteria::ASC]))
            ->map(function (Play $play) {
                return $play->getTeam()->getName();
            });
        $this->assertEquals([
            'A', 'B'
        ], array_values($names->toArray()));

        $names = $stage->getPlays()
            ->matching(Criteria::create()
                ->orderBy([self::STAGE_ORDER => Criteria::ASC]))
            ->map(function (Play $play) {
                return $play->getOpponent()->getName();
            });
        $this->assertEquals([
            'C', 'D'
        ], array_values($names->toArray()));

        $stage = $playoffStages->next();
        $names = $stage->getPlays()
            ->matching(Criteria::create()
                ->orderBy([self::STAGE_ORDER => Criteria::ASC]))
            ->map(function (Play $play) {
                return $play->getTeam()->getName();
            });
        $this->assertEquals([
            'A'
        ], array_values($names->toArray()));

        $names = $stage->getPlays()
            ->matching(Criteria::create()
                ->orderBy([self::STAGE_ORDER => Criteria::ASC]))
            ->map(function (Play $play) {
                return $play->getOpponent()->getName();
            });
        $this->assertEquals([
            'B'
        ], array_values($names->toArray()));
    }
}

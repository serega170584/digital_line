<?php

namespace App\Tests\Service;


use App\Entity\Group;
use App\Entity\Team;
use App\Repository\GroupRepository;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TeamGeneratorTest extends KernelTestCase
{
    const ID = 'id';
    const NAME = 'name';
    const GROUP = 'teamGroup';

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

        /**
         * @var GroupRepository $groupRepository
         */
        $groupRepository = $container->get(GroupRepository::class);

        /**
         * @var Group $group
         */
        $group = current($groupRepository->findBy([self::NAME => 'A'], [self::ID => Criteria::ASC]));
        /**
         * @var Team[] $stages
         */
        $teams = $teamRepository->findBy([self::GROUP => $group], [self::ID => Criteria::ASC]);
        $names = array_map(function (Team $team) {
            return $team->getName();
        }, $teams);
        $this->assertEqualsCanonicalizing($names, [
            'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H',
        ]);
    }
}

<?php

namespace App\Tests\Service;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GroupGeneratorTest extends KernelTestCase
{
    const ID = 'id';

    public function testGenerate()
    {
        self::bootKernel();
        $container = static::getContainer();
        /**
         * @var GroupRepository $groupRepository
         */
        $groupRepository = $container->get(GroupRepository::class);
        /**
         * @var Group[] $groups
         */
        $groups = $groupRepository->findBy([],[self::ID => Criteria::ASC]);
        $names = array_map(function (Group $group) {
            return $group->getName();
        }, $groups);
        $this->assertEquals($names, ['A', 'B']);
    }
}

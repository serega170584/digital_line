<?php

namespace App\Tests\Service;


use App\Entity\Group;
use App\Repository\StageRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StageGeneratorTest extends KernelTestCase
{
    const ID = 'id';

    public function testGenerate()
    {
        self::bootKernel();
        $container = static::getContainer();
        /**
         * @var StageRepository $stageRepository
         */
        $stageRepository = $container->get(StageRepository::class);
        /**
         * @var Stage[] $stages
         */
        $stages = $stageRepository->findBy([], [self::ID => Criteria::ASC]);
        $names = array_map(function (Group $group) {
            return $group->getName();
        }, $stages);
        $this->assertEqualsCanonicalizing($names, [
            'Preliminary round',
            '1/4',
            '1/2',
            'Final'
        ]);
    }
}

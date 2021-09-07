<?php

namespace App\DataFixtures;

use App\Domain\Generator\CompetitionGenerator;
use App\Domain\Generator\GroupGenerator;
use App\Domain\Generator\PlayGenerator;
use App\Domain\Generator\StageGenerator;
use App\Domain\Generator\TeamGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class DigitalLineFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Doctrine\ORM\ORMException
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectManager|EntityManagerInterface $manager
         */
        $generator = new CompetitionGenerator(null);
        $generator->setManager($manager);
        $stageGenerator = new StageGenerator(null);
        $stageGenerator->setManager($manager);
        $generator->setStageGenerator($stageGenerator);
        $groupGenerator = new GroupGenerator(null);
        $groupGenerator->setManager($manager);
        $generator->setGroupGenerator($groupGenerator);
        $teamGenerator = new TeamGenerator(null);
        $teamGenerator->setManager($manager);
        $generator->setTeamGenerator($teamGenerator);
        $playGenerator = new PlayGenerator(null);
        $playGenerator->setManager($manager);
        $generator->setPlayGenerator($playGenerator);
        $generator->execute();
    }
}

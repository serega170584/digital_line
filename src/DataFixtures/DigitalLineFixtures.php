<?php

namespace App\DataFixtures;

use App\Domain\Generator\FixturesCompetitionGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DigitalLineFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->
        $generator = new FixturesCompetitionGenerator($manager);
//        new CompetitionGenerator()
        $manager->flush();
    }
}

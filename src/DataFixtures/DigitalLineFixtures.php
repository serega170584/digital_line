<?php

namespace App\DataFixtures;

use App\Domain\Generator\FixturesCompetitionGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class DigitalLineFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectManager|EntityManagerInterface $manager
         */
        $generator = new FixturesCompetitionGenerator($manager);
        $generator->execute();
    }
}

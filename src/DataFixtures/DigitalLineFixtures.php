<?php

namespace App\DataFixtures;

use App\Domain\Generator\CompetitionGenerator;
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
        $generator->execute();
    }
}

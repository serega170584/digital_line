<?php

namespace App\DataFixtures;

use App\Domain\Generator\CompetitionGenerator;
use App\Repository\StageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DigitalLineFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
<?php

namespace App\Tests\Service;


use App\Entity\Group;
use App\Entity\Play;
use App\Repository\PlayRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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
    }
}

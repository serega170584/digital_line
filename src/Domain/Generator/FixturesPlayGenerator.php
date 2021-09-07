<?php


namespace App\Domain\Generator;


use App\Entity\Play;

class FixturesPlayGenerator extends Generator
{
    use PlayGeneratorTrait;

    public function createEntityObject(): Play
    {
        return new Play();
    }
}
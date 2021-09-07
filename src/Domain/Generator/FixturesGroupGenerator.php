<?php

namespace App\Domain\Generator;

use App\Entity\Group;

class FixturesGroupGenerator extends Generator
{
    use GroupGeneratorTrait;

    public function createEntityObject(): Group
    {
        return new Group();
    }
}
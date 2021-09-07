<?php

namespace App\Domain\Generator;

use App\Entity\Stage;

class FixturesStageGenerator extends Generator
{
    use StageGeneratorTrait;

    public function createEntityObject(): Stage
    {
        return new Stage();
    }
}
<?php


namespace App\Domain\Generator;


use App\Entity\Team;

class FixturesTeamGenerator extends Generator
{
    use TeamGeneratorTrait;

    public function createEntityObject(): Team
    {
        return new Team();
    }
}
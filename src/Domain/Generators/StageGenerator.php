<?php


namespace App\Domain\Generators;


class StageGenerator extends Generator
{
    public function generate()
    {
        $this->records = [['Preliminary round', false]];
    }
}
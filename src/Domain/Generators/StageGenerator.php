<?php


namespace App\Domain\Generators;


class StageGenerator extends Generator
{
    public function generate(): self
    {
        $this->records = [['Preliminary round', false]];
        return $this;
    }
}
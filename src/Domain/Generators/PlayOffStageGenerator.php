<?php


namespace App\Domain\Generators;


class PlayOffStageGenerator extends Generator
{

    public function generate(): self
    {
        $this->records = [['1/4', true], ['1/2', true], ['Final', true]];
        return $this;
    }
}
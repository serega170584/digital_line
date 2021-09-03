<?php


namespace App\Domain\Generators;


class PlayOffStageGenerator extends Generator
{

    public function generate(): self
    {
        $this->records = [['1/4', true]];
        $this->records = [['1/2', true]];
        $this->records = [['Final', true]];
        return $this;
    }
}
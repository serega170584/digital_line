<?php


namespace App\Domain\Generator;


class PlayOffStageGeneratorInterface
{

    public function execute(): self
    {
        $this->records = [['1/4', true], ['1/2', true], ['Final', true]];
        return $this;
    }
}
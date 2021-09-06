<?php


namespace App\Domain\Generator;


class GroupGeneratorInterface
{
    /**
     * @return $this
     */
    public function execute(): self
    {
        $this->records = [['A'], ['B']];
        return $this;
    }
}
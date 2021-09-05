<?php


namespace App\Domain\Generators;


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
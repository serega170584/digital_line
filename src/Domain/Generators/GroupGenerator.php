<?php


namespace App\Domain\Generators;


class GroupGenerator extends Generator
{
    /**
     * @return $this
     */
    public function generate(): self
    {
        $this->records = [['A'], ['B']];
        return $this;
    }
}
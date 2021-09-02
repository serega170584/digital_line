<?php


namespace App\Domain;


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
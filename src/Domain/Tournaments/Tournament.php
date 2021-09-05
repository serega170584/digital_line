<?php


namespace App\Domain\Tournaments;


use App\Domain\Collections\StageArrayCollection;

abstract class Tournament
{
    /**
     * @var StageArrayCollection
     */
    protected $stages;

    abstract public function build();

    /**
     * @param StageArrayCollection $stages
     */
    public function setStages(StageArrayCollection $stages): void
    {
        $this->stages = $stages;
    }
}

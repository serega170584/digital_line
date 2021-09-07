<?php


namespace App\Domain\Generator;

/**
 * Trait CompetitionGeneratorTrait
 * @package App\Domain\Generator
 * @method bool isEmpty()
 * @method flush()
 * @property StageGenerator $stageGenerator
 * @property GroupGenerator $groupGenerator
 * @property TeamGenerator $teamGenerator
 * @property PlayGenerator $playGenerator
 */
trait CompetitionGeneratorTrait
{
    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function execute(): self
    {
        if ($this->isEmpty()) {
            $stageGenerator = $this->stageGenerator;
            $stageGenerator->execute();
            $groupGenerator = $this->groupGenerator;
            $groupGenerator->execute();
            $teamGenerator = $this->teamGenerator;
            $teamGenerator->setGroups($groupGenerator->getGroups());
            $teamGenerator->execute();
            $playGenerator = $this->playGenerator;
            $playGenerator->setStages($stageGenerator->getStages());
            $playGenerator->setTeams($teamGenerator->getTeams());
            $playGenerator->execute();
            $this->flush();
        }
        return $this;
    }
}
<?php


namespace App\Domain\Generators;


use App\Domain\Strategies\PlainPointStrategy;
use App\Entity\Team;
use App\Repository\TeamRepository;

class TeamPointsGenerator extends Generator
{

    /**
     * @var TeamRepository
     */
    private $teamRepository;
    /**
     * @var PlainPointStrategy
     */
    private $plainPointStrategy;

    public function __construct(TeamRepository $teamRepository, PlainPointStrategy $plainPointStrategy)
    {
        parent::__construct();
        $this->teamRepository = $teamRepository;
        $this->plainPointStrategy = $plainPointStrategy;
    }

    /**
     * @return $this
     */
    public function generate(): self
    {
        $teams = $this->teamRepository->getEntities();
        foreach ($teams as $team) {
            /**
             * @var Team $team
             */
            $team->setPoints($this->plainPointStrategy->calculate($team));
        }
        return $this;
    }
}
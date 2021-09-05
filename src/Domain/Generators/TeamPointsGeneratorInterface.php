<?php


namespace App\Domain\Generators;


use App\Domain\Strategies\PointStrategy;
use App\Entity\Team;
use App\Repository\TeamRepository;

class TeamPointsGeneratorInterface extends GeneratorInterface
{

    /**
     * @var TeamRepository
     */
    private $teamRepository;
    /**
     * @var PointStrategy
     */
    private $pointStrategy;

    public function __construct(TeamRepository $teamRepository)
    {
        parent::__construct();
        $this->teamRepository = $teamRepository;
    }

    /**
     * @return $this
     */
    public function execute(): self
    {
        $teams = $this->teamRepository->getEntities();
        foreach ($teams as $team) {
            /**
             * @var Team $team
             */
            $team->setPoints($this->pointStrategy->calculate($team));
        }
        return $this;
    }

    /**
     * @param PointStrategy $pointStrategy
     */
    public function setPointStrategy(PointStrategy $pointStrategy): void
    {
        $this->pointStrategy = $pointStrategy;
    }
}
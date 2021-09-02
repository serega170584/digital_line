<?php


namespace App\Domain\Generators;


use App\Entity\Play;
use App\Entity\Team;
use App\Repository\TeamRepository;

class TeamPointsGenerator extends Generator
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        parent::__construct();
        $this->teamRepository = $teamRepository;
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
            $plays = $team->getPlays();
            $points = $plays->map(function ($play) {
                /**
                 * @var Play $play
                 */
                return $play->getScoredGoals();
            });
            $team->setPoints($points);
        }
        return $this;
    }
}
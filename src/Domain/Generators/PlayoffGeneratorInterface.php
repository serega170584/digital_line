<?php


namespace App\Domain\Generators;


use App\Domain\Strategies\PlayoffGridStrategy;
use App\Domain\Tournaments\GroupTournament;
use App\Repository\StageRepository;

class PlayoffGeneratorInterface
{
    /**
     * @var GroupTournament
     */
    private $groupTournament;
    /**
     * @var PlayoffGridStrategy
     */
    private $playoffGridStrategy;
    /**
     * @var StageRepository
     */
    private $stageRepository;

    public function __construct(GroupTournament $groupTournament, StageRepository $stageRepository)
    {
        parent::__construct();
        $this->groupTournament = $groupTournament;
        $this->stageRepository = $stageRepository;
    }

    public function execute(): self
    {
        $winners = $this->groupTournament->getWinners();
        $grid = $this->playoffGridStrategy->calculatePreliminaryRoundGrid($winners);
        foreach ($this->stageRepository->getEntities() as $stage) {
            $playWinners = [];
            foreach ($grid as $play) {
                $playWinner = array_shift($play);
                $this->records[] = [$playWinner, array_shift($play), $stage, 1, 0];
                $playWinners[] = $playWinner;
            }
            $grid = [];
            while ($playWinners) {
                $grid[] = [array_shift($playWinners), array_shift($playWinners)];
            }
        }
        return $this;
    }

    /**
     * @param PlayoffGridStrategy $playoffGridStrategy
     */
    public function setPlayoffGridStrategy(PlayoffGridStrategy $playoffGridStrategy): void
    {
        $this->playoffGridStrategy = $playoffGridStrategy;
    }
}
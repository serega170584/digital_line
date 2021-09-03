<?php


namespace App\Domain\Generators;


use App\Domain\Tournaments\GroupTournament;
use App\Repository\PlayRepository;
use App\Repository\StageRepository;

class PlayoffGenerator extends Generator
{
    /**
     * @var PlayRepository
     */
    private $playRepository;
    /**
     * @var StageRepository
     */
    private $stageRepository;
    /**
     * @var GroupTournament
     */
    private $groupTournament;

    public function __construct(PlayRepository $playRepository, StageRepository $stageRepository, GroupTournament $groupTournament)
    {
        parent::__construct();
        $this->playRepository = $playRepository;
        $this->stageRepository = $stageRepository;
        $this->groupTournament = $groupTournament;
    }

    public function generate()
    {
        $winners = $this->groupTournament->getWinners();
        var_dump(count($winners));
        die('asd');
    }
}
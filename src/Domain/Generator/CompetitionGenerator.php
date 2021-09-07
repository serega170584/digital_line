<?php


namespace App\Domain\Generator;


use App\Repository\GroupRepository;
use App\Repository\PlayRepository;
use App\Repository\StageRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;

class CompetitionGenerator extends Generator
{
    use CompetitionGeneratorTrait;

    /**
     * @var StageGenerator
     */
    private $stageGenerator;
    /**
     * @var GroupGenerator
     */
    private $groupGenerator;
    /**
     * @var TeamGenerator
     */
    private $teamGenerator;
    /**
     * @var PlayGenerator
     */
    private $playGenerator;

    /**
     * CompetitionGenerator constructor.
     * @param EntityManagerInterface $entityManager
     * @param StageGenerator $stageGenerator
     * @param GroupGenerator $groupGenerator
     * @param TeamGenerator $teamGenerator
     * @param PlayGenerator $playGenerator
     */
    public function __construct(EntityManagerInterface $entityManager,
                                StageGenerator $stageGenerator,
                                GroupGenerator $groupGenerator,
                                TeamGenerator $teamGenerator,
                                PlayGenerator $playGenerator
    )
    {
        parent::__construct($entityManager);
        $this->stageGenerator = $stageGenerator;
        $this->groupGenerator = $groupGenerator;
        $this->teamGenerator = $teamGenerator;
        $this->playGenerator = $playGenerator;
    }

    public function isEmpty(): bool
    {
        return !$this->stageRepository->count([]);
    }

}
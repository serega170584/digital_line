<?php


namespace App\Domain\Generator;


use App\Repository\StageRepository;
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
     * @var StageRepository
     */
    private $stageRepository;

    /**
     * CompetitionGenerator constructor.
     * @param EntityManagerInterface $entityManager
     * @param StageGenerator $stageGenerator
     * @param GroupGenerator $groupGenerator
     * @param TeamGenerator $teamGenerator
     * @param PlayGenerator $playGenerator
     * @param StageRepository $stageRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
                                StageGenerator $stageGenerator,
                                GroupGenerator $groupGenerator,
                                TeamGenerator $teamGenerator,
                                PlayGenerator $playGenerator,
                                StageRepository $stageRepository
    )
    {
        parent::__construct($entityManager);
        $this->stageGenerator = $stageGenerator;
        $this->groupGenerator = $groupGenerator;
        $this->teamGenerator = $teamGenerator;
        $this->playGenerator = $playGenerator;
        $this->stageRepository = $stageRepository;
    }

    public function isEmpty(): bool
    {
        return !$this->stageRepository->count([]);
    }

}
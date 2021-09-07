<?php


namespace App\Domain\Generator;


use App\Repository\GroupRepository;
use App\Repository\PlayRepository;
use App\Repository\StageRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;

class CompetitionGenerator extends Generator
{
    /**
     * @var StageGenerator
     */
    private $stageGenerator;
    /**
     * @var StageRepository
     */
    private $stageRepository;
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
     * @param StageRepository $stageRepository
     * @param GroupGenerator $groupGenerator
     * @param TeamGenerator $teamGenerator
     * @param PlayGenerator $playGenerator
     */
    public function __construct(EntityManagerInterface $entityManager,
                                StageGenerator $stageGenerator, StageRepository $stageRepository,
                                GroupGenerator $groupGenerator,
                                TeamGenerator $teamGenerator,
                                PlayGenerator $playGenerator
    )
    {
        parent::__construct($entityManager);
        $this->stageGenerator = $stageGenerator;
        $this->stageRepository = $stageRepository;
        $this->groupGenerator = $groupGenerator;
        $this->teamGenerator = $teamGenerator;
        $this->playGenerator = $playGenerator;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function execute(): self
    {
        if (!$this->stageRepository->count([])) {
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
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
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var TeamGenerator
     */
    private $teamGenerator;
    /**
     * @var TeamRepository
     */
    private $teamRepository;
    /**
     * @var PlayGenerator
     */
    private $playGenerator;
    /**
     * @var PlayRepository
     */
    private $playRepository;

    /**
     * CompetitionGenerator constructor.
     * @param EntityManagerInterface $entityManager
     * @param StageGenerator $stageGenerator
     * @param StageRepository $stageRepository
     * @param GroupGenerator $groupGenerator
     * @param GroupRepository $groupRepository
     * @param TeamGenerator $teamGenerator
     * @param TeamRepository $teamRepository
     * @param PlayGenerator $playGenerator
     * @param PlayRepository $playRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
                                StageGenerator $stageGenerator, StageRepository $stageRepository,
                                GroupGenerator $groupGenerator, GroupRepository $groupRepository,
                                TeamGenerator $teamGenerator, TeamRepository $teamRepository,
                                PlayGenerator $playGenerator, PlayRepository $playRepository
    )
    {
        parent::__construct($entityManager);
        $this->stageGenerator = $stageGenerator;
        $this->stageRepository = $stageRepository;
        $this->groupGenerator = $groupGenerator;
        $this->groupRepository = $groupRepository;
        $this->teamGenerator = $teamGenerator;
        $this->teamRepository = $teamRepository;
        $this->playGenerator = $playGenerator;
        $this->playRepository = $playRepository;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function execute(): self
    {
        if (!$this->stageRepository->count([])) {
            $stageGenerator = $this->stageGenerator;
            $stageGenerator->setRepository($this->stageRepository);
            $stageGenerator->execute();
            $groupGenerator = $this->groupGenerator;
            $groupGenerator->setRepository($this->groupRepository);
            $groupGenerator->execute();
            $teamGenerator = $this->teamGenerator;
            $teamGenerator->setRepository($this->teamRepository);
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
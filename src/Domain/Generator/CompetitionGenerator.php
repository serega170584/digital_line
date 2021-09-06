<?php


namespace App\Domain\Generator;


use App\Repository\GroupRepository;
use App\Repository\StageRepository;
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
     * CompetitionGenerator constructor.
     * @param EntityManagerInterface $entityManager
     * @param StageGenerator $stageGenerator
     * @param StageRepository $stageRepository
     * @param GroupGenerator $groupGenerator
     * @param GroupRepository $groupRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
                                StageGenerator $stageGenerator, StageRepository $stageRepository,
                                GroupGenerator $groupGenerator, GroupRepository $groupRepository
    )
    {
        parent::__construct($entityManager);
        $this->stageGenerator = $stageGenerator;
        $this->stageRepository = $stageRepository;
        $this->groupGenerator = $groupGenerator;
        $this->groupRepository = $groupRepository;
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
            $this->flush();
        }
        return $this;
    }
}
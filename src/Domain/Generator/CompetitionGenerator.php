<?php


namespace App\Domain\Generator;


use App\Entity\Stage;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class CompetitionGenerator extends Generator
{
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
     * @param EntityManagerInterface|null $entityManager
     * @param StageGenerator $stageGenerator
     * @param GroupGenerator $groupGenerator
     * @param TeamGenerator $teamGenerator
     * @param PlayGenerator $playGenerator
     */
    public function __construct(?EntityManagerInterface $entityManager,
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
        $this->stageRepository = $this->entityManager->getRepository(Stage::class);
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
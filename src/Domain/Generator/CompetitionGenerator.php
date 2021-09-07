<?php


namespace App\Domain\Generator;


use App\Domain\Repository\RepositoryInterface;
use App\Entity\Group;
use App\Entity\Play;
use App\Entity\Stage;
use App\Entity\Team;
use App\Repository\StageRepository;

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
     * @throws \Doctrine\ORM\ORMException
     */
    public function execute(): self
    {
        $stageRepository = $this->manager->getRepository(Stage::class);
        if (!$stageRepository->count([])) {
            $stageGenerator = $this->stageGenerator;
            /**
             * @var RepositoryInterface $repository
             */
            $repository = $this
                ->manager
                ->getRepository(Stage::class);
            $stageGenerator->setRepository($repository);
            $stageGenerator->execute();
            $groupGenerator = $this->groupGenerator;
            $repository = $this
                ->manager
                ->getRepository(Group::class);
            $groupGenerator->setRepository($repository);
            $groupGenerator->execute();
            $teamGenerator = $this->teamGenerator;
            $teamGenerator->setGroups($groupGenerator->getGroups());
            $repository = $this
                ->manager
                ->getRepository(Team::class);
            $teamGenerator->setRepository($repository);
            $teamGenerator->execute();
            $playGenerator = $this->playGenerator;
            $playGenerator->setStages($stageGenerator->getStages());
            $playGenerator->setTeams($teamGenerator->getTeams());
            $repository = $this
                ->manager
                ->getRepository(Play::class);
            $playGenerator->setRepository($repository);
            $playGenerator->execute();
            $this->flush();
        }
        return $this;
    }

    /**
     * @param StageGenerator $stageGenerator
     */
    public function setStageGenerator(StageGenerator $stageGenerator): void
    {
        $this->stageGenerator = $stageGenerator;
    }

    /**
     * @param GroupGenerator $groupGenerator
     */
    public function setGroupGenerator(GroupGenerator $groupGenerator): void
    {
        $this->groupGenerator = $groupGenerator;
    }

    /**
     * @param TeamGenerator $teamGenerator
     */
    public function setTeamGenerator(TeamGenerator $teamGenerator): void
    {
        $this->teamGenerator = $teamGenerator;
    }

    /**
     * @param PlayGenerator $playGenerator
     */
    public function setPlayGenerator(PlayGenerator $playGenerator): void
    {
        $this->playGenerator = $playGenerator;
    }

    /**
     * @param StageRepository $stageRepository
     */
    public function setStageRepository(StageRepository $stageRepository): void
    {
        $this->stageRepository = $stageRepository;
    }
}
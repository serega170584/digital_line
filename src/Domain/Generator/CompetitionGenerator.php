<?php


namespace App\Domain\Generator;


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

    public function __construct(EntityManagerInterface $entityManager,
                                StageGenerator $stageGenerator, StageRepository $stageRepository)
    {
        parent::__construct($entityManager);
        $this->stageGenerator = $stageGenerator;
        $this->stageRepository = $stageRepository;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function execute()
    {
        $stageGenerator = $this->stageGenerator;
        $stageGenerator->setRepository($this->stageRepository);
        $stageGenerator->execute();
    }
}
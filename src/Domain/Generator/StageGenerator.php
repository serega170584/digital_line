<?php


namespace App\Domain\Generator;

use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class StageGenerator
 * @package App\Domain\Generators
 */
class StageGenerator extends Generator
{
    use GeneratorTrait, StageGeneratorTrait;

    /**
     * @var StageRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, StageRepository $stageRepository)
    {
        parent::__construct($entityManager);
        $this->repository = $stageRepository;
    }
}
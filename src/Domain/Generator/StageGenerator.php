<?php

namespace App\Domain\Generator;

use App\Repository\StageRepository;
use Doctrine\Persistence\ObjectManager;

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

    public function __construct(ObjectManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $entityManager->getRepository(StageRepository::class);
    }

}
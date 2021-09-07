<?php

namespace App\Domain\Generator;

use App\Repository\StageRepository;

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

    /**
     * @param StageRepository $repository
     */
    public function setRepository(StageRepository $repository): void
    {
        $this->repository = $repository;
    }
}
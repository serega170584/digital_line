<?php

namespace App\Domain\Generator;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Doctrine\Persistence\ObjectManager;

class GroupGenerator extends Generator
{
    use GeneratorTrait, GroupGeneratorTrait;

    /**
     * @var Group[]
     */
    private $groups;
    /**
     * @var GroupRepository
     */
    private $repository;

    public function __construct(ObjectManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $entityManager->getRepository(GroupRepository::class);
    }

    /**
     * @return Group[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }
}
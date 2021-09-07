<?php

namespace App\Domain\Generator;

use App\Entity\Group;
use App\Repository\GroupRepository;

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

    /**
     * @return Group[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @param GroupRepository $repository
     */
    public function setRepository(GroupRepository $repository): void
    {
        $this->repository = $repository;
    }
}
<?php

namespace App\Domain\Generator;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;

class GroupGenerator extends Generator
{
    use GeneratorTrait;

    /**
     * @var Group[]
     */
    private $groups;
    /**
     * @var GroupRepository
     */
    private $repository;

    public function __construct(?EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $entityManager->getRepository(Group::class);
    }

    /**
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     */
    public function execute()
    {
        $records = ['A', 'B'];
        foreach ($records as $name) {
            $entityObject = $this->createEntityObject();
            $entityObject->setName($name);
            $this->persist($entityObject);
            $this->groups[] = $entityObject;
        }
        return $this;
    }

    /**
     * @return Group[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }
}
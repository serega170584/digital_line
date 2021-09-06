<?php


namespace App\Domain\Generator;


use App\Entity\Group;

class GroupGenerator extends Generator
{
    /**
     * @var Group[]
     */
    private $groups;

    /**
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     */
    public function execute(): self
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
<?php


namespace App\Domain\Generator;


class GroupGenerator extends Generator
{
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
        }
        return $this;
    }
}
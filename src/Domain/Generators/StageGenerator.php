<?php


namespace App\Domain\Generators;

/**
 * Class StageGenerator
 * @package App\Domain\Generators
 */
class StageGenerator extends Generator
{
    /**
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     */
    public function execute(): self
    {
        $records = [
            ['Preliminary round', false],
            ['1/4', true],
            ['1/2', true],
            ['Final', true]
        ];
        foreach ($records as $record) {
            $entityObject = $this->createEntityObject();
            $entityObject->setName($record[0]);
            $entityObject->setIsPlayoff($record[1]);
            $this->persist($entityObject);
        }
        $this->flush();
        return $this;
    }
}
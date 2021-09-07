<?php

namespace App\Domain\Generator;

use App\Entity\Stage;

/**
 * Trait StageGeneratorTrait
 * @package App\Domain\Generator
 * @method Stage createEntityObject()
 * @method persist($entityObject)
 * @property Stage[] $stages

 */
trait StageGeneratorTrait
{
    /**
     * @var Stage[]
     */
    private $stages;

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
            $this->stages[] = $entityObject;
            $this->persist($entityObject);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getStages(): array
    {
        return $this->stages;
    }
}
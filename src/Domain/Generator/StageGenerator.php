<?php


namespace App\Domain\Generator;

use App\Entity\Stage;

/**
 * Class StageGenerator
 * @package App\Domain\Generators
 */
class StageGenerator extends Generator
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
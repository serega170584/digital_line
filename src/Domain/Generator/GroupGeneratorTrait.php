<?php


namespace App\Domain\Generator;

use App\Entity\Group;

/**
 * Trait GroupGeneratorTrait
 * @package App\Domain\Generator
 * @method Group createEntityObject()
 * @method persist($entityObject)
 * @property Group[] $groups
 */
trait GroupGeneratorTrait
{
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
}
<?php


namespace App\Domain;


use App\Repository\GroupRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

class GroupGenerator extends Generator
{
    public function __construct(GroupRepository $repository)
    {
        parent::__construct($repository);
        $this->records = new ArrayCollection();
        $fields = new ArrayCollection();
        $fields->add('A');
        $this->records->add($fields);
        $fields->clear();
        $fields->add('B');
        $this->records->add($fields);
    }

    public function generate()
    {
        $records = $this->records;
        foreach ($records as $fields) {
            $this->repository->addEntity($fields);
        }
    }
}
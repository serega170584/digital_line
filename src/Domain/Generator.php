<?php


namespace App\Domain;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

abstract class Generator
{
    /**
     * @var ArrayCollection
     */
    protected $records;
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    abstract public function generate();
}
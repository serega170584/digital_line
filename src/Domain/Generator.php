<?php


namespace App\Domain;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class Generator
{
    /**
     * @var ServiceEntityRepository
     */
    protected $repository;

    public function __construct(ServiceEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    abstract public function generate();
}
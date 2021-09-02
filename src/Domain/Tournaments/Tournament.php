<?php


namespace App\Domain\Tournaments;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class Tournament
{
    /**
     * @var ServiceEntityRepository $repository
     */
    protected $repository;

    /**
     * @var array
     */
    protected $units;

    public function __construct(ServiceEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public abstract function getUnits();

}

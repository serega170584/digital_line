<?php


namespace App\Domain\Tournaments;


use App\Repository\GroupRepository;

class GroupTournament extends Tournament
{
    /**
     * @var GroupRepository $repository
     */
    protected $repository;

    public function __construct(GroupRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @return mixed
     */
    public function getUnits()
    {
        return $this->repository->findGroups();
    }
}
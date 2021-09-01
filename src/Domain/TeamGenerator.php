<?php


namespace App\Domain;


use App\Repository\TeamRepository;

class TeamGenerator extends Generator
{
    public function __construct(TeamRepository $repository)
    {
        parent::__construct($repository);
    }

    public function generate()
    {

    }
}
<?php


namespace App\Domain;


use App\Repository\StageRepository;

class StageGenerator extends Generator
{
    public function __construct(StageRepository $repository)
    {
        parent::__construct($repository);
    }

    public function generate()
    {

    }
}
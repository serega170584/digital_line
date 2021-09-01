<?php


namespace App\Domain;


use App\Repository\PlayRepository;

class PlayGenerator extends Generator
{
    public function __construct(PlayRepository $repository)
    {
        parent::__construct($repository);
    }

    public function generate()
    {

    }
}
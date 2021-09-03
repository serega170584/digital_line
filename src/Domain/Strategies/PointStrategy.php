<?php


namespace App\Domain\Strategies;


use App\Entity\Team;

abstract class PointStrategy
{
    abstract public function calculate(Team $team);
}
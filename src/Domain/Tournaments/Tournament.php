<?php


namespace App\Domain\Tournaments;


abstract class Tournament
{
    abstract public function build();

    abstract public function buildTable();
}
<?php

namespace App\Domain\Tournaments;

interface TournamentInterface
{
    public function build();

    public function buildTable();
}

<?php


namespace App\Domain\Strategies;


abstract class PlayoffGridStrategy
{
    /**
     * @param $winners
     * @return mixed
     */
    abstract public function calculatePreliminaryRoundGrid($winners);
}
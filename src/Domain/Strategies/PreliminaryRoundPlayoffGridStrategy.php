<?php


namespace App\Domain\Strategies;


use App\Entity\Team;

class PreliminaryRoundPlayoffGridStrategy extends PlayoffGridStrategy
{

    /**
     * @param Team[] $winners
     * @return mixed|void
     */
    public function calculatePreliminaryRoundGrid($winners)
    {
        $firstHalf = [];
        $secondHalf = [];
        while ($winners) {
            $firstHalf[] = [array_shift($winners), array_pop($winners)];
            $secondHalf[] = [array_shift($winners), array_pop($winners)];
        }
        return array_merge($firstHalf, $secondHalf);
    }
}
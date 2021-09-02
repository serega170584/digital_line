<?php


namespace App\Domain\Strategies;


use App\Entity\Team;

class PlainPointStrategy extends PointStrategy
{

    /**
     * @param Team $team
     * @return int
     */
    public function calculate($team)
    {
        $plays = $team->getPlays();
        $points = 0;
        foreach ($plays as $play) {
            $points += $play->getScoredGoals();
        }
        return $points;
    }
}
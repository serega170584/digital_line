<?php


namespace App\Domain\Collections;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class StageArrayCollection extends ArrayCollection
{
    const IS_PLAYOFF = 'isPlayoff';

    /**
     * @return StageArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function findIsPlayoff()
    {
        return $this->matching(Criteria::create()
            ->where(Criteria::expr()
                ->eq('isPlayoff', true)));
    }

    /**
     * @return StageArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function findIsGroup()
    {
        return $this->matching(Criteria::create()
            ->where(Criteria::expr()
                ->eq(self::IS_PLAYOFF, false)));
    }
}
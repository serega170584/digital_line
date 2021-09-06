<?php


namespace App\Domain\Tournaments;


use App\Domain\Collection\StageArrayCollection;
use App\Entity\Stage;
use App\Repository\StageRepository;
use Doctrine\Common\Collections\Criteria;

class PlayoffTournament implements TournamentInterface
{
    /**
     * @var StageRepository $repository
     */
    protected $repository;
    /**
     * @var StageArrayCollection|Stage[]
     */
    private $stages;

    public function build()
    {
        foreach ($this->stages as $stage) {
            /**
             * @var Stage $stage
             */
            $plays = $stage->getPlays()->matching(Criteria::create()
                ->orderBy([
                    'stageOrder' => Criteria::ASC,
                ])
            );
            $stage->setOrderedPlays($plays);
        }
    }

    /**
     * @param StageArrayCollection $stages
     */
    public function setStages(StageArrayCollection $stages): void
    {
        $this->stages = $stages;
    }

    /**
     * @return StageArrayCollection|Stage[]
     */
    public function getStages()
    {
        return $this->stages;
    }
}
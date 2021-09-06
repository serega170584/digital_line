<?php


namespace App\Domain\Tournaments;


use App\Domain\Collection\StageArrayCollection;
use App\Entity\Stage;
use App\Entity\Team;
use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class PlayoffTournament implements TournamentInterface
{
    const STAGE_ORDER = 'stageOrder';
    const ID = 'id';
    const POINTS = 'points';
    /**
     * @var StageRepository $repository
     */
    protected $repository;
    /**
     * @var StageArrayCollection|Stage[]
     */
    private $stages;
    /**
     * @var Team[]
     */
    private $table;

    public function build()
    {
        foreach ($this->stages as $stage) {
            /**
             * @var Stage $stage
             */
            $plays = $stage->getPlays()->matching(Criteria::create()
                ->orderBy([
                    self::STAGE_ORDER => Criteria::ASC,
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

    public function buildTable()
    {
        $teams = new ArrayCollection();
        $stages = $this->stages->matching(Criteria::create()
            ->orderBy([
                self::ID => Criteria::DESC,
            ])
        );
        foreach ($this->stages as $stage) {
            $stageWinners = new ArrayCollection();
            foreach ($stage->getPlays() as $play) {
                $team = $play->getTeam();
                $opponent = $play->getOpponent();
                $stageWinner = ($play->getScoredGoals() > $play->getLostGoals()) ? $team : $opponent;
                if (!$teams->contains($stageWinner)) {
                    $stageWinners->add($stageWinner);
                }
            }
            $stageWinners = $stageWinners->matching(Criteria::create()
                ->orderBy([
                    self::POINTS => Criteria::DESC,
                ])
            );
            $teams = new ArrayCollection(array_merge($teams->toArray(), $stageWinners->toArray()));
        }
        $this->table = $teams;
    }
}
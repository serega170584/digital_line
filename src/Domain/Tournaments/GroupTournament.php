<?php


namespace App\Domain\Tournaments;


use App\Domain\Collection\StageArrayCollection;
use App\Entity\Group;
use App\Entity\Play;
use App\Entity\Stage;
use App\Entity\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

const POINTS = 'points';

class GroupTournament implements TournamentInterface
{
    const ID = 'id';
    const TEAM = 'team';
    const OPPONENT = 'opponent';
    const WINNERS_COUNT = 4;

    /**
     * @var StageArrayCollection
     */
    private $playoffStages;
    /**
     * @var ArrayCollection
     */
    private $groups;
    /**
     * @var Stage
     */
    private $stage;
    /**
     * @var ArrayCollection
     */
    private $table;

    public function build()
    {
        /**
         * @var Stage $stage
         */
        $stage = $this->playoffStages->matching(Criteria::create()
            ->orderBy([self::ID => Criteria::ASC]))
            ->first();
        /**
         * @var Play $play
         */
        $play = $stage->getPlays()->first();
        $this->groups = new ArrayCollection([
            $play->getTeam()->getTeamGroup(),
            $play->getOpponent()->getTeamGroup()
        ]);
        $this->buildTable();
    }

    /**
     * @param StageArrayCollection $playoffStages
     */
    public function setPlayoffStages(StageArrayCollection $playoffStages): void
    {
        $this->playoffStages = $playoffStages;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups(): ArrayCollection
    {
        return $this->groups;
    }

    /**
     * @param Stage $stage
     */
    public function setStage(Stage $stage): void
    {
        $this->stage = $stage;
    }

    /**
     * @param Team $team
     * @return Play[]
     */
    public function findTeamPlays(Team $team)
    {
        return $this->stage->getPlays()->matching(Criteria::create()
            ->where(Criteria::expr()->eq(self::TEAM, $team))
            ->orderBy([
                self::TEAM => Criteria::ASC,
                self::OPPONENT => Criteria::ASC
            ])
        );
    }

    /**
     * @return $this
     */
    public function buildTable(): self
    {
        $losers = $this->groups->map(function (Group $group) {
            $group->getTeams()->matching(Criteria::create()
                ->orderBy([
                    POINTS => Criteria::DESC,
                ])
            )->slice(self::WINNERS_COUNT);
        });
        var_dump(count($losers));
        $losers = $losers->toArray();
        $losers = new ArrayCollection(array_merge(...$losers));
        $losers = $losers->matching(Criteria::create()
            ->orderBy([
                POINTS => Criteria::DESC,
                self::ID => Criteria::ASC
            ]));
        $this->table = $losers;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTable(): ArrayCollection
    {
        return $this->table;
    }
}
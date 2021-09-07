<?php

namespace App\Entity;

use App\Repository\PlayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\PlayRepository::class)
 * @ORM\Table(name="play", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="team_opponent_stage_idx", columns={"team_id", "opponent_id", "stage_id"})
 * }, indexes={@ORM\Index(name="stage_order_id_idx", columns={"stage_order"})})
 */
class Play
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="plays", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="plays", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $opponent;

    /**
     * @ORM\ManyToOne(targetEntity=Stage::class, inversedBy="plays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stage;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoredGoals;

    /**
     * @ORM\Column(type="integer")
     */
    private $lostGoals;

    /**
     * @ORM\Column(type="integer")
     */
    private $stageOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getOpponent(): ?Team
    {
        return $this->opponent;
    }

    public function setOpponent(?Team $opponent): self
    {
        $this->opponent = $opponent;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): self
    {
        $this->stage = $stage;

        return $this;
    }

    public function getScoredGoals(): ?int
    {
        return $this->scoredGoals;
    }

    public function setScoredGoals(int $scoredGoals): self
    {
        $this->scoredGoals = $scoredGoals;

        return $this;
    }

    public function getLostGoals(): ?int
    {
        return $this->lostGoals;
    }

    public function setLostGoals(int $lostGoals): self
    {
        $this->lostGoals = $lostGoals;

        return $this;
    }

    public function getStageOrder(): ?int
    {
        return $this->stageOrder;
    }

    public function setStageOrder(int $stageOrder): self
    {
        $this->stageOrder = $stageOrder;

        return $this;
    }
}

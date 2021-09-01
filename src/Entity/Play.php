<?php

namespace App\Entity;

use App\Repository\PlayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayRepository::class)
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
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="plays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $еteam;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="plays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $opponent;

    /**
     * @ORM\ManyToOne(targetEntity=Stage::class, inversedBy="plays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getеteam(): ?Team
    {
        return $this->еteam;
    }

    public function setеteam(?Team $еteam): self
    {
        $this->еteam = $еteam;

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
}

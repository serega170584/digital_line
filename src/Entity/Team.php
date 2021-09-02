<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="points_idx", columns={"points"})})
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Play::class, mappedBy="team", orphanRemoval=true)
     */
    private $plays;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="teams", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $teamGroup;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $points;

    public function __construct()
    {
        $this->plays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Play[]
     */
    public function getPlays(): Collection
    {
        return $this->plays;
    }

    public function addPlay(Play $play): self
    {
        if (!$this->plays->contains($play)) {
            $this->plays[] = $play;
            $play->setTeam($this);
        }

        return $this;
    }

    public function removePlay(Play $play): self
    {
        if ($this->plays->removeElement($play)) {
            // set the owning side to null (unless already changed)
            if ($play->getTeam() === $this) {
                $play->setTeam(null);
            }
        }

        return $this;
    }

    public function getTeamGroup(): ?Group
    {
        return $this->teamGroup;
    }

    public function setTeamGroup(?Group $teamGroup): self
    {
        $this->teamGroup = $teamGroup;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }
}

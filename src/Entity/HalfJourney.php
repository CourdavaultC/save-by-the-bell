<?php

namespace App\Entity;

use App\Repository\HalfJourneyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HalfJourneyRepository::class)
 */
class HalfJourney
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="datetime")
     */
    private $half_date;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="half_journeys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\OneToMany(targetEntity=Presences::class, mappedBy="halfJourney", orphanRemoval=true)
     */
    private $presences;

    public function __construct()
    {
        $this->presences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHalfDate(): ?\DateTimeInterface
    {
        return $this->half_date;
    }

    public function setHalfDate(\DateTimeInterface $half_date): self
    {
        $this->half_date = $half_date;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return Collection|Presences[]
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presences $presence): self
    {
        if (!$this->presences->contains($presence)) {
            $this->presences[] = $presence;
            $presence->setHalfJourney($this);
        }

        return $this;
    }

    public function removePresence(Presences $presence): self
    {
        if ($this->presences->contains($presence)) {
            $this->presences->removeElement($presence);
            // set the owning side to null (unless already changed)
            if ($presence->getHalfJourney() === $this) {
                $presence->setHalfJourney(null);
            }
        }

        return $this;
    }

}

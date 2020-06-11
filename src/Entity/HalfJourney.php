<?php

namespace App\Entity;

use App\Repository\HalfJourneyRepository;
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
     * @ORM\Column(type="boolean")
     */
    private $presences;

    /**
     * @ORM\Column(type="datetime")
     */
    private $half_date;

    /**
     * @ORM\ManyToOne(targetEntity=presences::class)
     */
    private $relation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresences(): ?bool
    {
        return $this->presences;
    }

    public function setPresences(bool $presences): self
    {
        $this->presences = $presences;

        return $this;
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

    public function getRelation(): ?presences
    {
        return $this->relation;
    }

    public function setRelation(?presences $relation): self
    {
        $this->relation = $relation;

        return $this;
    }
}

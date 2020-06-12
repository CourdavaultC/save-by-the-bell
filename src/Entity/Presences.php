<?php

namespace App\Entity;

use App\Repository\PresencesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PresencesRepository::class)
 */
class Presences
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=HalfJourney::class, inversedBy="presences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $halfJourney;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="presence")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHalfJourney(): ?HalfJourney
    {
        return $this->halfJourney;
    }

    public function setHalfJourney(?HalfJourney $halfJourney): self
    {
        $this->halfJourney = $halfJourney;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}

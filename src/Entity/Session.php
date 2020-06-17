<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_end;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="session", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=HalfJourney::class, mappedBy="session", orphanRemoval=true)
     */
    private $half_journeys;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->half_journeys = new ArrayCollection();
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setSession($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getSession() === $this) {
                $user->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HalfJourney[]
     */
    public function getHalfJourneys(): Collection
    {
        return $this->half_journeys;
    }

    public function addHalfJourney(HalfJourney $halfJourney): self
    {
        if (!$this->half_journeys->contains($halfJourney)) {
            $this->half_journeys[] = $halfJourney;
            $halfJourney->setSession($this);
        }

        return $this;
    }

    public function removeHalfJourney(HalfJourney $halfJourney): self
    {
        if ($this->half_journeys->contains($halfJourney)) {
            $this->half_journeys->removeElement($halfJourney);
            // set the owning side to null (unless already changed)
            if ($halfJourney->getSession() === $this) {
                $halfJourney->setSession(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

}

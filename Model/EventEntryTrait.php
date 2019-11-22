<?php

namespace Owp\OwpEvent\Model\Event;

Trait EventEntryTrait
{
    /**
     * @ORM\Column(type="boolean")
     */
    protected $allowEntries;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateEntries;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $numberPeopleByEntries;

    /**
     * @ORM\OneToMany(targetEntity="Team", cascade={"persist", "remove"}, mappedBy="event")
     */
    protected $teams;

    /**
     * @ORM\OneToMany(targetEntity="People", cascade={"persist", "remove"}, mappedBy="event")
     */
    protected $peoples;

    public function getAllowEntries(): ?bool
    {
        return $this->allowEntries;
    }

    public function setAllowEntries(bool $allowEntries): self
    {
        $this->allowEntries = $allowEntries;

        return $this;
    }

    public function getDateEntries(): ?\DateTimeInterface
    {
        return $this->dateEntries;
    }

    public function setDateEntries($dateEntries): self
    {
        $this->dateEntries = $dateEntries;

        return $this;
    }

    public function getNumberPeopleByEntries(): ?int
    {
        return $this->numberPeopleByEntries;
    }

    public function setNumberPeopleByEntries($numberPeopleByEntries): self
    {
        $this->numberPeopleByEntries = $numberPeopleByEntries;

        return $this;
    }

    public function getTeams()
    {
        return $this->teams;
    }

    public function getPeoples()
    {
        return $this->peoples;
    }
}

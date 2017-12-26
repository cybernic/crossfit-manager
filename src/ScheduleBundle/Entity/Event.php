<?php

namespace ScheduleBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="ScheduleBundle\Repository\EventRepository")
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Program")
     * @ORM\JoinColumn(nullable=false)
     */
    private $program;

    /**
     * Coach user
     *
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @ORM\Column(type="datetime")
     */
    private $startsAt;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(min=15, max=120)
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * One Event has Many Reservations.
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="event")
     * @ORM\OrderBy({"createdAt"="ASC"})
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getProgram()->getTitle();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Program
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * @param Program $program
     */
    public function setProgram(Program $program)
    {
        $this->program = $program;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \DateTime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param \DateTime $startsAt
     */
    public function setStartsAt(\DateTime $startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param integer $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return ArrayCollection|Reservation[]
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @return bool
     */
    public function canBeCanceled()
    {
        return ($this->getStartsAt()->format('U') - time() - 3600) > 0;
    }

    /**
     * @return int
     */
    public function reservedPlacesPercent()
    {
        if (count($this->getReservations()) >= $this->getProgram()->getPlaces()) {
            return 100;
        }

        return (int)(count($this->getReservations()) / $this->getProgram()->getPlaces() * 100);
    }
}
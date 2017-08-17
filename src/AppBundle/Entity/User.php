<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ScheduleBundle\Entity\Event;
use ScheduleBundle\Entity\Reservation;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="`fos_user`")
 */
class User extends \FOS\UserBundle\Model\User implements \Avanzu\AdminThemeBundle\Model\UserInterface
{
    const ROLE_COACH = 'ROLE_COACH';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $surname = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * One User has Many Reservations.
     * @ORM\OneToMany(targetEntity="ScheduleBundle\Entity\Reservation", mappedBy="user")
     */
    private $reservations;

    public function __construct()
    {
        parent::__construct();

        $this->createdAt = new \DateTime();
        $this->reservations = new ArrayCollection();
    }

    public function getAvatar()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getMemberSince()
    {
        return '';
    }

    public function isOnline()
    {
        return true;
    }

    public function getIdentifier()
    {
        return '';
    }

    public function getTitle()
    {
        return '';
    }

    public function setEmail($email)
    {
        $this->setUsername($email);

        return parent::setEmail($email);
    }

    public function getShortName()
    {
        $shortNameParts   = [];
        $shortNameParts[] = $this->getName();

        foreach(explode(' ', $this->getSurname()) as $surname) {
            $shortNameParts[] = strtoupper(substr(trim($surname), 0, 1)) . '.';
        }

        return implode(' ', $shortNameParts);
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


    /**
     * @return ArrayCollection|Reservation[]
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @param Event $event
     * @return bool
     */
    public function hasReservation($event)
    {
        foreach ($event->getReservations() as $reservation) {
            if ($reservation->getUser() === $this) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Event $event
     * @return bool|mixed|Reservation
     */
    public function getReservationByEvent(Event $event)
    {
        foreach ($event->getReservations() as $reservation) {
            if ($reservation->getUser() === $this) {
                return $reservation;
            }
        }

        return false;
    }
}
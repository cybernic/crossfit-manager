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
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * One User has Many Reservations.
     * @ORM\OneToMany(targetEntity="ScheduleBundle\Entity\Reservation", mappedBy="user")
     */
    private $reservations;

    public function __construct()
    {
        parent::__construct();

        $this->reservations = new ArrayCollection();
    }

    public function getAvatar()
    {
        return '';
    }

    public function getName()
    {
        return '';
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
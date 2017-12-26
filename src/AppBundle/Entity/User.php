<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ScheduleBundle\Entity\Event;
use ScheduleBundle\Entity\Reservation;
use ScheduleBundle\Entity\Subscription;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="`fos_user`")
 * @Vich\Uploadable()
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * One User has Many Reservations.
     * @ORM\OneToMany(targetEntity="ScheduleBundle\Entity\Reservation", mappedBy="user")
     */
    private $reservations;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $paidUntil;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="ScheduleBundle\Entity\Subscription")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subscription;

    public function __construct()
    {
        parent::__construct();

        $this->createdAt = new \DateTime();
        $this->reservations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getShortName();
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

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
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
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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

    /**
     * @return \DateTime
     */
    public function getPaidUntil()
    {
        return $this->paidUntil;
    }

    /**
     * @param \DateTime $paidUntil
     */
    public function setPaidUntil($paidUntil)
    {
        $this->paidUntil = $paidUntil;
    }

    /**
     * @return Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
    }
}
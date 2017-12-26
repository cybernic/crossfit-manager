<?php

namespace ScheduleBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="ScheduleBundle\Repository\SubscriptionRepository")
 * @ORM\Table(name="subscription")
 */
class Subscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(min=0, max=7)
     * @ORM\Column(type="integer")
     */
    private $weeklyTrainings;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * One Subscription has Many Users.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="subscription")
     * @ORM\OrderBy({"name"="ASC"})
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function __toString()
    {
        return "{$this->getWeeklyTrainings()} entrenamientos/semana";
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * @return int
     */
    public function getWeeklyTrainings()
    {
        return $this->weeklyTrainings;
    }

    /**
     * @param int $weeklyTrainings
     */
    public function setWeeklyTrainings($weeklyTrainings)
    {
        $this->weeklyTrainings = $weeklyTrainings;
    }

    /**
     * @return ArrayCollection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
}
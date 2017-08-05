<?php

namespace ScheduleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="ScheduleBundle\Repository\ProgramRepository")
 * @ORM\Table(name="program")
 */
class Program
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true, length=7, options={"fixed" = true})
     */
    private $color;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    public function __construct($title = null, $description = null, $color = '#fff', $isActive = 1)
    {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setColor($color);
        $this->setActive($isActive);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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

    public function __construct()
    {
        parent::__construct();

        // your own logic
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
}
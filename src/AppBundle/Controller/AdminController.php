<?php

namespace AppBundle\Controller;

class AdminController extends \JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController
{
    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}

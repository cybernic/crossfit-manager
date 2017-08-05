<?php
namespace MyThemeBundle\EventListener;

use AppBundle\Entity\User;
use Avanzu\AdminThemeBundle\Event\ShowUserEvent;

class ShowUserListener
{
    use \Symfony\Component\DependencyInjection\ContainerAwareTrait;

    public function onShowUser(ShowUserEvent $event)
    {
        $event->setUser(
            $this->getUser()
        );
    }

    protected function getUser()
    {
        return $this->container->get('security.token_storage')->getToken()->getUser();
    }
}
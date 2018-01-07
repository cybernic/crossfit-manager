<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use AppBundle\Entity\User;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            'easy_admin.pre_persist' => ['sendNewUserEmail'],
        ];
    }

    public function sendNewUserEmail(GenericEvent $event)
    {
        /** @var User $user */
        $user = $event->getSubject();

        if (!($user instanceof User) || $user->getId() !== null) {
            return;
        }

        $message = (new \Swift_Message('Your crossfit user data'))
            ->setTo($user->getEmail())
            ->setBody("
                Hello {$user->getName()},\n
                Your credentials to login to crossfit scheduler:\n\n 
                Login: {$user->getEmail()}\n
                Password: {$user->getPlainPassword()}\n
            ");

        $this->mailer->send($message);
    }
}
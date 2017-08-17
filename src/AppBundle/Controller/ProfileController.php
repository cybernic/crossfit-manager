<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller managing the user profile.
 * Overrides
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends \FOS\UserBundle\Controller\ProfileController
{
    /**
     * Show the user.
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();

        $notifications = $em->getRepository('ScheduleBundle:Notification')->getLastNotifications();

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'notifications' => [],
        ));
    }
}
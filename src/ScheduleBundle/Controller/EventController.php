<?php

namespace ScheduleBundle\Controller;

use ScheduleBundle\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * @Route("/event/new")
     */
    public function newAction()
    {

    }

    /**
     * @Route("/event/{id}", name="schedule_event_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('ScheduleBundle:Event')->find($id);

        if (!$event) {
            throw $this->createNotFoundException('No event with that ID');
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
}

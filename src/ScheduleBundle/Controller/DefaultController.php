<?php

namespace ScheduleBundle\Controller;

use ScheduleBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/schedule")
     */
    public function indexAction()
    {
        return $this->render('schedule/index.html.twig');
    }

    /**
     * @Route("/schedule/events", name="schedule_get_events")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getEventsAction()
    {
        $data = [];

        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('ScheduleBundle:Event')->findNextEvents();

        /** @var Event $event */
        foreach ($events as $event) {
            $program = $event->getProgram();

            $data[] = [
                'title' => $program->getTitle(),
                'start' => $event->getStartsAt()->format('Y-m-d H:i:s'),
                'end' => $event->getStartsAt()->add(new \DateInterval("PT{$event->getDuration()}M"))->format('Y-m-d H:i:s'),
                'backgroundColor' => $program->getColor(),
                'borderColor' => $program->getColor(),
                'allDay' => false,
            ];
        }

        return $this->json($data);

    }
}

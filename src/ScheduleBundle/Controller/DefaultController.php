<?php

namespace ScheduleBundle\Controller;

use ScheduleBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/schedule", name="schedule_default_index")
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
            $progressPercent = (int)(count($event->getReservations()) / $program->getPlaces() * 100);
            $progress = '<div class="progress progress-xxs" style="margin:2px 0 0;">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$progressPercent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$progressPercent.'%">
                  <span class="sr-only">'.$progressPercent.'%</span>
                </div>
              </div>';
            $reservations = '<br><small>Reservas: ' . count($event->getReservations()) .  ' de ' . $program->getPlaces() . '</small>' . $progress;

            $data[] = [
                'title' => $program->getTitle() . $reservations,
                'start' => $event->getStartsAt()->format('Y-m-d H:i:s'),
                'end' => $event->getStartsAt()->add(
                    new \DateInterval("PT{$event->getDuration()}M")
                )->format('Y-m-d H:i:s'),
                'backgroundColor' => $program->getColor(),
                'borderColor' => $program->getColor(),
                'allDay' => false,
                'url' => $this->generateUrl('schedule_event_show', ['id' => $event->getId()]),
            ];
        }

        return $this->json($data);

    }
}

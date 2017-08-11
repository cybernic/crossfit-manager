<?php

namespace ScheduleBundle\Controller;

use AppBundle\Entity\User;
use ScheduleBundle\Entity\Event;
use ScheduleBundle\Entity\Program;
use ScheduleBundle\Entity\Reservation;
use ScheduleBundle\Form\EventFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * @Route("/event/create", name="schedule_event_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(EventFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'El evento creado con éxito.');

            return $this->redirectToRoute('schedule');
        }

        return $this->render('event/create.html.twig', [
            'eventForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/event/{id}", name="schedule_event_show")
     */
    public function showAction($id)
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $event = $this->getEvent($id);

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'hasReservation' => $user->hasReservation($event),
        ]);
    }

    /**
     * @Route("/event/reserve/{id}", name="schedule_event_reserve")
     */
    public function reserveAction($id)
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $event = $this->getEvent($id);

        if (!$user->hasReservation($event)) {
            $reservation = new Reservation();
            $reservation->setEvent($event);
            $reservation->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            $this->addFlash('success', '¡Enhorabuena! Has reservado tu plaza.');
        } else {
            $this->addFlash('error', 'Ya has reservado tu plaza.');
        }

        return $this->redirectToRoute('schedule_event_show', ['id' => $id]);
    }

    /**
     * @Route("/event/cancel-reservation/{id}", name="schedule_event_cancel_reservation")
     */
    public function cancelReservationAction($id)
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $event = $this->getEvent($id);

        if ($user->hasReservation($event)) {
            $reservation = $user->getReservationByEvent($event);

            $em = $this->getDoctrine()->getManager();
            /*
            $reservation = $em->getRepository("ScheduleBundle:Reservation")->findOneBy([
                'user_id' => $user->getId(),
                'event_id' => $event->getId(),
            ]);*/

            $em->remove($reservation);
            $em->flush();

            $this->addFlash('success', 'Has cancelado tu reserva.');
        } else {
            $this->addFlash('error', 'No tienes la reserva de este evento');
        }

        return $this->redirectToRoute('schedule_event_show', ['id' => $id]);
    }

    /**
     * @param integer $id
     * @return Event|null|object
     */
    private function getEvent($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('ScheduleBundle:Event')->find($id);

        if (!$event) {
            throw $this->createNotFoundException('No event with that ID');
        }

        return $event;
    }
}

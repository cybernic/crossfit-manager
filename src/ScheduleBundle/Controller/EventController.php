<?php

namespace ScheduleBundle\Controller;

use AppBundle\Entity\User;
use ScheduleBundle\Entity\Event;
use ScheduleBundle\Entity\Reservation;
use ScheduleBundle\Form\EventFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    /**
     * @Route("/event/create", name="schedule_event_create")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(EventFormType::class);
        $form->handleRequest($request);

        $form->add('days', ChoiceType::class, [
            'choices' => array_flip(EventFormType::daysOfWeek()),
            'multiple' => true,
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            /** @var \DateTime $firstDate */
            $firstDate = $event->getStartsAt();

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            if (!empty($event->getDays())) {
                foreach ($event->getDays() as $day) {
                    $newEvent = clone $event;
                    $newEvent->getStartsAt()->modify("{$day} this week")->setTime($firstDate->format('H'), $firstDate->format('i'));

                    if ($firstDate->getTimestamp() !== $newEvent->getStartsAt()->getTimestamp()) {
                        $em->persist($newEvent);
                        $em->flush();
                    }
                }
            }

            $this->addFlash('success', 'El evento creado con éxito.');

            return $this->redirectToRoute('schedule_default_index');
        }

        return $this->render('event/create.html.twig', [
            'eventForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/event/{id}/update", name="schedule_event_update")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateAction(Request $request, Event $event)
    {
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'El evento guardado con éxito.');

            return $this->redirectToRoute('schedule_event_show', ['id' => $event->getId()]);
        }

        return $this->render('event/update.html.twig', [
            'eventForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/event/{id}", name="schedule_event_show")
     */
    public function showAction(Event $event)
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'hasReservation' => $user->hasReservation($event),
            'isAdmin' => $this->getUser()->hasRole('ROLE_ADMIN'),
        ]);
    }

    /**
     * @Route("/event/{id}/reserve", name="schedule_event_reserve")
     */
    public function reserveAction(Event $event)
    {
        /** @var User $user */
        $user = $this->getUser();

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

        return $this->redirectToRoute('schedule_event_show', ['id' => $event->getId()]);
    }

    /**
     * @Route("/event/{id}/drop", name="schedule_event_drop")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function dropAction(Event $event)
    {
        if ($event->getReservations()->count() > 0) {
            $this->addFlash('error', 'No se ha podido eliminar el evento. Primero cancela todas las reservas.');
            return $this->redirectToRoute('schedule_event_show', ['id' => $event->getId()]);
        }

        $event->setIsActive(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();

        $this->addFlash('success', 'El evento se ha eliminado con éxito.');

        return $this->redirectToRoute('schedule_program_index');
    }

    /**
     * @Route("/event/{id}/cancel-reservation", name="schedule_event_cancel_reservation")
     */
    public function cancelReservationAction(Event $event)
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($event->canReserve() && $user->hasReservation($event)) {
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

        return $this->redirectToRoute('schedule_event_show', ['id' => $event->getId()]);
    }
}

<?php

namespace ScheduleBundle\Controller;

use ScheduleBundle\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ProgramController extends Controller
{
    /**
     * @Route("/program/new")
     */
    public function newAction()
    {
        $program = new Program('PERSONAL COACH', 'Entrenador Personal');

        $em = $this->getDoctrine()->getManager();
        $em->persist($program);
        $em->flush();


        return new Response('Program created');
        return $this->render('ScheduleBundle:Default:index.html.twig');
    }


    /**
     * @Route("/program", name="schedule_program_index")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        dump($em->getRepository('ScheduleBundle:Program'));
        $programs = $em->getRepository('ScheduleBundle:Program')->findAllActive();

        return $this->render('program/list.html.twig', [
            'programs' => $programs,
        ]);
    }

    /**
     * @Route("/program/{id}", name="schedule_program_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $program = $em->getRepository('ScheduleBundle:Program')->find($id);

        if (!$program) {
            throw $this->createNotFoundException('No program with that ID');
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }
}

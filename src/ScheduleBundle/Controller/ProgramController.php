<?php

namespace ScheduleBundle\Controller;

use ScheduleBundle\Entity\Program;
use ScheduleBundle\Form\ProgramFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgramController extends Controller
{
    /**
     * @Route("/program/create", name="schedule_program_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(ProgramFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $program = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($program);
            $em->flush();

            $this->addFlash('success', 'El programa creado con éxito.');

            return $this->redirectToRoute('schedule_program_index');
        }

        return $this->render('program/create.html.twig', [
            'programForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/program", name="schedule_program_index")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
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

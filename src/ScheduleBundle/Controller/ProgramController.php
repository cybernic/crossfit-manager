<?php

namespace ScheduleBundle\Controller;

use ScheduleBundle\Entity\Program;
use ScheduleBundle\Form\ProgramFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
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
     * @Route("/program/{id}/edit", name="schedule_program_edit")
     */
    public function editAction(Request $request, Program $program)
    {
        $form = $this->createForm(ProgramFormType::class, $program);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $program = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($program);
            $em->flush();

            $this->addFlash('success', 'El programa se ha guardado con éxito.');

            return $this->redirectToRoute('schedule_program_index');
        }

        return $this->render('program/edit.html.twig', [
            'programForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/program/{id}/drop", name="schedule_program_drop")
     */
    public function dropAction(Program $program)
    {
        $program->setIsActive(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($program);
        $em->flush();

        $this->addFlash('success', 'El programa se ha eliminado con éxito.');

        return $this->redirectToRoute('schedule_program_index');
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
    public function showAction(Program $program)
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }
}

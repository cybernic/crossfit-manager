<?php

namespace ScheduleBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use ScheduleBundle\Entity\Program;
use ScheduleBundle\Repository\ProgramRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('program', EntityType::class, [
                'class' => Program::class,
                'placeholder' => 'Selecciona programa',
                'query_builder' => function (ProgramRepository $repo) {
                    return $repo->createActiveOnlyQueryBuilder();
                }
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'placeholder' => 'Selecciona un entrenador',
                'query_builder' => function (UserRepository $repo) {
                    return $repo->createTrainerOnlyQueryBuilder();
                }
            ])
            ->add('startsAt', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'hours' => range(10, 21),
                'minutes' => [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55],
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                    'data-date-format' => 'yy-mm-dd',
                ]
            ])
            ->add('duration', ChoiceType::class, [
                'choices' => array_combine(
                    [15, 20, 25, 30, 35, 40, 45, 50, 55],
                    [15, 20, 25, 30, 35, 40, 45, 50, 55]
                )
            ])
            ->add('days', ChoiceType::class, [
                'choices' => array_flip(EventFormType::daysOfWeek()),
                'multiple' => true,
                'required' => false,
            ]);


        /*$builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if (true) {
                $form->add('days', ChoiceType::class, [
                    'choices' => array_flip(EventFormType::daysOfWeek()),
                    'multiple' => true,
                ]);
            }
        });*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'ScheduleBundle\Entity\Event',
        ]);
    }

    public static function daysOfWeek()
    {
        return [
            'monday' => 'Lunes',
            'tuesday' => 'Martes',
            'wednesday' => 'Miercoles',
            'thursday' => 'Jueves',
            'friday' => 'Viernes',
            'saturday' => 'Sabado',
            'sunday' => 'Domingo',
        ];
    }
}
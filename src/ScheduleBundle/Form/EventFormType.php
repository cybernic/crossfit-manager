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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('program', EntityType::class, [
                'class' => Program::class,
                'placeholder' => 'Selecciona programa',
                'query_builder' => function(ProgramRepository $repo) {
                    return $repo->createActiveOnlyQueryBuilder();
                }
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'placeholder' => 'Selecciona un entrenador',
                'query_builder' => function(UserRepository $repo) {
                    return $repo->createTrainerOnlyQueryBuilder();
                }
            ])
            ->add('startsAt', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                //'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                ]
            ])
            ->add('duration', ChoiceType::class, [
                'choices' => array_combine(
                    [15, 30, 45, 60, 75, 90, 115, 120],
                    [15, 30, 45, 60, 75, 90, 115, 120]
                )
            ])

            ->add('isActive', ChoiceType::class, [
                'choices' => [
                    'Sí' => true,
                    'No' => false,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'ScheduleBundle\Entity\Event',
        ]);
    }
}
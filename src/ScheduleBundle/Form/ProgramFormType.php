<?php

namespace ScheduleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('color')
            ->add('places', ChoiceType::class, [
                'choices' => array_combine(range(1, 20), range(1, 20)),
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
            'data_class' => 'ScheduleBundle\Entity\Program',
        ]);
    }
}
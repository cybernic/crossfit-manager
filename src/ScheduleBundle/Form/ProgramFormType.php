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
            ->add('title', null, ['trim' => true])
            ->add('description', null, ['trim' => true])
            ->add('color', null, ['trim' => true])
            ->add('places', ChoiceType::class, [
                'choices' => array_combine(range(1, 20), range(1, 20)),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'ScheduleBundle\Entity\Program',
        ]);
    }
}
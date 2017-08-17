<?php

namespace AppBundle\Form;

use \Symfony\Component\Form\AbstractType;
use \Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['trim' => true])
            ->add('surname', null, ['trim' => true])
            ->remove('username')
        ;
    }

    public function getParent()
    {
        return \FOS\UserBundle\Form\Type\ProfileFormType::class;
    }
}
<?php

namespace AppBundle\Form;

use \Symfony\Component\Form\AbstractType;
use \Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['trim' => true])
            ->add('surname', null, ['trim' => true])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'imagine_pattern' => 'avatar_128x128',
                'allow_delete' => false,
                'download_link' => false,
            ])
            ->remove('username')
        ;
    }

    public function getParent()
    {
        return \FOS\UserBundle\Form\Type\ProfileFormType::class;
    }
}
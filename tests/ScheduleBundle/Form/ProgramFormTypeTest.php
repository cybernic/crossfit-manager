<?php

namespace Tests\ScheduleBundle\Form;

use ScheduleBundle\Entity\Program;
use ScheduleBundle\Form\ProgramFormType;
use Symfony\Component\Form\Test\TypeTestCase;


class ProgramFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'title' => 'Test title',
            'color' => '#f1f1f1',
        );

        $form = $this->factory->create(ProgramFormType::class);

        $object = new Program();
        $object->setColor($formData['color']);
        $object->setTitle($formData['title']);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());
        $this->assertTrue($form->isValid());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

}

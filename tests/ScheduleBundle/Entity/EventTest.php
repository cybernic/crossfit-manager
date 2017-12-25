<?php

namespace Tests\ScheduleBundle\Form;

use ScheduleBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EventTest extends TestCase
{
    public function testCanReserve()
    {
        $event = new Event();

        $event->setStartsAt(new \DateTime('2017-12-20 12:00:00'));
        $this->assertFalse($event->canBeCanceled());

        $event->setStartsAt(new \DateTime('2020-12-20 12:00:00'));
        $this->assertTrue($event->canBeCanceled());
    }
}

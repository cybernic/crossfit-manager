<?php

namespace Tests\ScheduleBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use ScheduleBundle\Entity\Event;
use ScheduleBundle\Entity\Program;
use ScheduleBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EventTest extends TestCase
{
    public function testCanBeReserved()
    {
        $event = new Event();

        $event->setStartsAt(new \DateTime('2017-12-20 12:00:00'));
        $this->assertFalse($event->canBeCanceled());

        $event->setStartsAt(new \DateTime('2020-12-20 12:00:00'));
        $this->assertTrue($event->canBeCanceled());
    }

    public function testReservedPlacesPercentCalculation()
    {
        $event = new ExtendedEvent();
        $program = new Program();

        $program->setPlaces(8);
        $event->setProgram($program);
        $this->assertTrue($event->reservedPlacesPercent() === 0);

        $event->setReservationsCount(1);
        $this->assertTrue($event->reservedPlacesPercent() === 12);

        $event->setReservationsCount(2);
        $this->assertTrue($event->reservedPlacesPercent() === 25);

        $event->setReservationsCount(3);
        $this->assertTrue($event->reservedPlacesPercent() === 37);

        $event->setReservationsCount(7);
        $this->assertTrue($event->reservedPlacesPercent() === 87);

        $event->setReservationsCount(8);
        $this->assertTrue($event->reservedPlacesPercent() === 100);

        $event->setReservationsCount(10);
        $this->assertTrue($event->reservedPlacesPercent() === 100);
    }
}

class ExtendedEvent extends Event
{
    private $reservationsCount = 0;

    public function getReservations()
    {
        if ($this->reservationsCount <= 0) {
            return new ArrayCollection();
        }

        return new ArrayCollection(range(1, $this->reservationsCount));
    }

    public function setReservationsCount($count)
    {
        $this->reservationsCount = $count;
    }
}


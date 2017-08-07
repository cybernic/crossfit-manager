<?php

namespace ScheduleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ScheduleBundle\Entity\Event;

class EventRepository extends EntityRepository
{
    /**
     * @return Event[]
     */
    public function findNextEvents()
    {
        return $this->createQueryBuilder('event')
            ->andWhere('event.isActive = :isActive')
            ->setParameter('isActive', true)
            ->orderBy('event.startsAt', 'ASC')
            ->getQuery()
            ->execute();
    }
}
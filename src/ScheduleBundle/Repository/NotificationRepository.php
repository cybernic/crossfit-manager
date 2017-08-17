<?php

namespace ScheduleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ScheduleBundle\Entity\Notification;

class NotificationRepository extends EntityRepository
{
    /**
     * @return Notification[]
     */
    public function getLastNotifications()
    {
        return $this->createQueryBuilder('notification')
            ->orderBy('notification.createdAt', 'DESC')
            ->setMaxResults(Notification::PAGE_SIZE)
            ->getQuery()
            ->execute();
    }
}
<?php

namespace ScheduleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ScheduleBundle\Entity\Subscription;

class SubscriptionRepository extends EntityRepository
{
    /**
     * @return Subscription[]
     */
    public function getSubscriptions()
    {
        return $this->createQueryBuilder('subscription')
            ->andWhere('subscription.isActive=:isActive')
            ->setParameter('isActive', true)
            ->orderBy('subscription.weeklyTrainings', 'ASC')
            ->getQuery()
            ->execute();
    }

    /**
     * @param int $trainings
     * @return Subscription
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getByWeeklyTrainings($trainings)
    {
        return $this->createQueryBuilder('subscription')
            ->where('subscription.weeklyTrainings=:trainings')
            ->andWhere('subscription.isActive=:isActive')
            ->setParameter('trainings', $trainings)
            ->setParameter('isActive', true)
            ->getQuery()
            ->getSingleResult();
    }
}
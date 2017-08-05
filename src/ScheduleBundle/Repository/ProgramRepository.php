<?php

namespace ScheduleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ScheduleBundle\Entity\Program;

class ProgramRepository extends EntityRepository
{
    /**
     * @return Program[]
     */
    public function findAllActive()
    {
        return $this->createQueryBuilder('program')
            ->andWhere('program.isActive = :isActive')
            ->setParameter('isActive', true)
            ->orderBy('program.title', 'ASC')
            ->getQuery()
            ->execute();
    }
}
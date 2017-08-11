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
        return $this->createActiveOnlyQueryBuilder()
            ->orderBy('program.title', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function createActiveOnlyQueryBuilder()
    {
        return $this->createQueryBuilder('program')
            ->andWhere('program.isActive = :isActive')
            ->setParameter('isActive', true);
    }
}
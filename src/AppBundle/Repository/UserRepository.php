<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @return User[]
     */
    public function findAllActive()
    {
        return $this->createTrainerOnlyQueryBuilder()
            ->orderBy('user.username', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function createTrainerOnlyQueryBuilder()
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.username = :username')
            ->setParameter('username', 'admin');
    }
}
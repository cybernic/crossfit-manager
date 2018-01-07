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
        return $this->createQueryBuilder('user')
            ->andWhere('user.enabled = 1')
            ->orderBy('user.username', 'ASC')
            ->getQuery()
            ->execute();
    }
}
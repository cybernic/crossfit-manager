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
        return $this->createActiveOnlyQueryBuilder()
            ->orderBy('user.username', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function createActiveOnlyQueryBuilder()
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.enabled = :enabled')
            ->setParameter('enabled', true);
    }

    public function createTrainerOnlyQueryBuilder()
    {
        return $this->createActiveOnlyQueryBuilder()
            ->andWhere('user.roles LIKE :roles')
            ->setParameter('roles', '%"' . User::ROLE_COACH . '"%');
    }
}
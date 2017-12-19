<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPlainPassword('1234');
        $userAdmin->setEmail('admin@example.com');
        $userAdmin->setName('Admin');
        $userAdmin->setSurname('Tester');
        $userAdmin->setEnabled(true);
        $userAdmin->addRole('ROLE_ADMIN');

        $manager->persist($userAdmin);
        $manager->flush();

        Fixtures::load(__DIR__ . '/fixtures.yml', $manager, [
            'providers' => [$this]
        ]);
    }

    public function eventDuration()
    {
        $duration = [30, 45, 60, 75, 90, 105, 120];

        return $duration[array_rand($duration)];
    }
}
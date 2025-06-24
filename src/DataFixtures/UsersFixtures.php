<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    const FIRST_USER = "first_user";
    const SECOND_USER = 'second_user';
    public function load(ObjectManager $manager): void
    {
        $user1 = new Users();
        $user1->setEmail('cfrodrigues9@gmail.com');
        $user1->setPlainPassword('demo');
        $user1->setUsername('nostrama');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user1);
        $this->addReference(self::FIRST_USER, $user1);

        $user2 = new Users();
        $user2->setEmail('toto@gmail.com');
        $user2->setPlainPassword('demo');
        $user2->setUsername('toto');
        $user2->setRoles(['ROLE_USER']);
        $user2->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user2);
        $this->addReference(self::SECOND_USER, $user2);

        $manager->flush();
    }
}

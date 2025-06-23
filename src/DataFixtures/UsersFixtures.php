<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    const FIRST_USER = "first_user";
    public function load(ObjectManager $manager): void
    {
        $user = new Users();
        $user->setEmail('cfrodrigues9@gmail.com');
        $user->setPlainPassword('demo');
        $user->setUsername('nostrama');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user);
        $this->addReference(self::FIRST_USER, $user);

        $manager->flush();
    }
}

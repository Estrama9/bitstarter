<?php

namespace App\DataFixtures;

use App\Entity\Savings;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SavingsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $account = new Savings();
        $account->setAmountBtc(1);
        $account->setUser($this->getReference(UsersFixtures::FIRST_USER, Users::class));
        $account->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($account);

        $manager->flush();
    }

    public function getDependencies(): array {

        return [
            UsersFixtures::class,
        ];
    }
}

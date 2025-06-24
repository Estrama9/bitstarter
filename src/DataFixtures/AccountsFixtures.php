<?php

namespace App\DataFixtures;

use App\Entity\Accounts;
use App\Entity\Users;
use App\Enum\AccountType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AccountsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $checking1 = new Accounts();
        $checking1->setAmountBtc(1);
        $checking1->setUser($this->getReference(UsersFixtures::FIRST_USER, Users::class));
        $checking1->setCreatedAt(new \DateTimeImmutable());
        $checking1->setType(AccountType::CHECKING);
        $manager->persist($checking1);

        $savings1 = new Accounts();
        $savings1->setAmountBtc(0);
        $savings1->setUser($this->getReference(UsersFixtures::FIRST_USER, Users::class));
        $savings1->setCreatedAt(new \DateTimeImmutable());
        $savings1->setType(AccountType::SAVINGS);
        $manager->persist($savings1);

        $checking2 = new Accounts();
        $checking2->setAmountBtc(1);
        $checking2->setUser($this->getReference(UsersFixtures::SECOND_USER, Users::class));
        $checking2->setCreatedAt(new \DateTimeImmutable());
        $checking2->setType(AccountType::CHECKING);
        $manager->persist($checking2);

        $savings2 = new Accounts();
        $savings2->setAmountBtc(0);
        $savings2->setUser($this->getReference(UsersFixtures::SECOND_USER, Users::class));
        $savings2->setCreatedAt(new \DateTimeImmutable());
        $savings2->setType(AccountType::SAVINGS);
        $manager->persist($savings2);

        $manager->flush();
    }

    public function getDependencies(): array {

        return [
            UsersFixtures::class,
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\DataFixtures\UsersFixtures;
use App\Entity\Transactions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TransactionsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $tip1 = new Transactions();
        $tip1->setAmountBtc(0.1);
        $tip1->setFromUser($this->getReference(UsersFixtures::FIRST_USER, Users::class));
        $tip1->setToUser($this->getReference(UsersFixtures::SECOND_USER, Users::class));
        $tip1->setMessage('for your contribution to the field');
        $tip1->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($tip1);


        $tip2 = new Transactions();
        $tip2->setAmountBtc(0.2);
        $tip2->setFromUser($this->getReference(UsersFixtures::SECOND_USER, Users::class));
        $tip2->setToUser($this->getReference(UsersFixtures::FIRST_USER, Users::class));
        $tip2->setMessage('You\'re welcome, thanks you too fo your work!');
        $tip2->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($tip2);

        $manager->flush();
    }

    public function getDependencies(): array {

        return [
            UsersFixtures::class,
        ];
    }
}

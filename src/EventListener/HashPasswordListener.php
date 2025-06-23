<?php

namespace App\EventListener;

use Doctrine\ORM\Events;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(Events::prePersist, method: 'hashPassword', entity: Users::class)]
#[AsEntityListener(Events::preUpdate, method: 'hashPassword', entity: Users::class)]
final class HashPasswordListener
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function hashPassword(Users $user): void
    {

        if(!$user->getPlainPassword()) {
            return;
        }

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $user->getPlainPassword()
        );
        $user->setPassword($hashedPassword);

    }
}

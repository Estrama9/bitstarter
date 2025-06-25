<?php

namespace App\Service;

use App\Entity\Accounts;
use App\Entity\Users;
use App\Enum\AccountType;
use Doctrine\ORM\EntityManagerInterface;

class UserOnboardingService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function createDefaultAccountsForUser(Users $user): void
    {
        if (!$user->getAccounts()->isEmpty()) {
            return;
        }

        foreach ([AccountType::CHECKING, AccountType::SAVINGS] as $type) {
            $account = new Accounts();
            $account->setType($type);
            $account->setUser($user);

            // Set amount depending on account type
            if ($type === AccountType::CHECKING) {
                $account->setAmountBtc(1);
            } else {
                $account->setAmountBtc(0);
            }

            $this->em->persist($account);
        }

        $this->em->flush();
    }
}

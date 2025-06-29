<?php

namespace App\Controller;

use App\Repository\AccountsRepository;
use App\Repository\TransactionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PortefeuilleController extends AbstractController
{
    #[Route('/portefeuille', name: 'app_portefeuille')]
    public function index(
        AccountsRepository $accountsRepository,
        TransactionsRepository $transactionsRepository,
        Security $security
    ): Response {
        $user = $security->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in.');
        }

        $checkingAccount = $accountsRepository->findOneBy([
            'user' => $user,
            'type' => 'CHECKING',
        ]);

        $savingsAccount = $accountsRepository->findOneBy([
            'user' => $user,
            'type' => 'SAVINGS',
        ]);

        $sentTransactions = $transactionsRepository->findBy(['from_user' => $user]);
        $receivedTransactions = $transactionsRepository->findBy(['to_user' => $user]);
        //dd($sentTransactions);

        $totalSent = array_sum(array_map(fn($t) => $t->getAmountBtc(), $sentTransactions));
        $totalReceived = array_sum(array_map(fn($t) => $t->getAmountBtc(), $receivedTransactions));


        $netAmount = $totalReceived - $totalSent;
        $computedBalance = $checkingAccount->getAmountBtc() + $netAmount;

        $transactions = $transactionsRepository->createQueryBuilder('t')
        ->where('t.from_user = :user OR t.to_user = :user')
        ->setParameter('user', $user)
        ->orderBy('t.createdAt', 'DESC')
        ->getQuery()
        ->getResult();


        return $this->render('portefeuille/index.html.twig', [
            'checkingAccount' => $checkingAccount,
            'savingsAccount' => $savingsAccount,
            'transactions' => $transactions, // ✅ add this
            'computedBalance' => $computedBalance,
            'username' => $user->getUserIdentifier(),
        ]);
    }

}

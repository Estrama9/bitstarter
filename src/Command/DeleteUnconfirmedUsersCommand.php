<?php

// src/Command/DeleteUnconfirmedUsersCommand.php

namespace App\Command;

use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:delete-unconfirmed-users')]
class DeleteUnconfirmedUsersCommand extends Command
{
    public function __construct(
        private readonly UsersRepository $userRepository,
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $threshold = new \DateTimeImmutable('-1 hours');
        $users = $this->userRepository->findUnconfirmedBefore($threshold);

        foreach ($users as $user) {
            $output->writeln("Deleting user ID {$user->getId()}");
            $this->em->remove($user);
        }

        $this->em->flush();

        return Command::SUCCESS;
    }
}

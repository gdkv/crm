<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create user',
)]
class CreateUserCommand extends Command
{
    private $passwordEncoder;
    private $entityManager;

    public function __construct(
        UserPasswordHasherInterface $passwordEncoder, 
        EntityManagerInterface $entityManager
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create user')
            ->addArgument('name', InputArgument::REQUIRED, 'Name')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $roles = [];
        $io = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name');
        $password = $input->getArgument('password');

        $output->writeln([
            '',
            'Admin Creator',
            '============================',
            '',
            '🧑  Name: '. $name,
            '🔑  Password: '. $password,
            '',
        ]);

        $user = new User();
        $user->setUsername($name);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $user->setRoles(["ROLE_ADMIN",]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('User was created');

        return Command::SUCCESS;
    }
}

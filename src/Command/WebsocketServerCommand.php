<?php

namespace App\Command;

use App\Websockets\MessageHandler;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ratchet\Http\HttpServer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'run:websocket-server',
    description: 'Add a short description for your command',
)]
class WebsocketServerCommand extends Command
{

    public function __construct(
        private int $websocketPort,
        private LoggerInterface $logger,
        private EntityManagerInterface $em,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Start websocket server')
            // ->addArgument('name', InputArgument::REQUIRED, 'Name')
            // ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ;
    }
 
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->info("Starting server on port {$this->websocketPort}");

        return Command::SUCCESS;
    }
}

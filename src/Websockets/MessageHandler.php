<?php
namespace App\Websockets;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class MessageHandler implements MessageComponentInterface
{
    protected SplObjectStorage $connections;

    public function __construct(
        private LoggerInterface $logger,
        private EntityManagerInterface $em
    ) 
    {
        $this->connections = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $connection)
    {
        $this->logger->critical("Connect");
        $this->connections->attach($connection);
    }
 
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $this->logger->info('{message}', ['message' => $msg, ]);
        
        foreach($this->connections as $connection) {
            if ($connection === $from) {
                continue;
            }
            $connection->send($msg);
        }
    }
 
    public function onClose(ConnectionInterface $connection)
    {
        $this->logger->critical("Close");
        $this->connections->detach($connection);
    }
 
    public function onError(ConnectionInterface $connection, Exception $e)
    {
        $this->logger->critical($e->getMessage());
        $this->connections->detach($connection);
        $connection->close();
    }

}
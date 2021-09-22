<?php
namespace App\Websocket;
 
use Exception;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class MessageHandler implements MessageComponentInterface
{
    protected SplObjectStorage $connections;

    public function __construct()
    {
        $this->connections = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $connection)
    {
        $this->connections->attach($connection);
    }
 
    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach($this->connections as $connection) {
            if ($connection === $from) {
                continue;
            }
            $connection->send($msg);
        }
    }
 
    public function onClose(ConnectionInterface $connection)
    {
        $this->connections->detach($connection);
    }
 
    public function onError(ConnectionInterface $connection, Exception $e)
    {
        $this->connections->detach($connection);
        $connection->close();
    }
}
<?php

require_once('ServerSocketConnection.class.php');

class ServerSocketProvider
{
    private $hostIP;
    private $port;
    private $socket;

    public function __construct($hostIP, $port)
    {
        $this->hostIP = $hostIP;
        $this->port = $port;
    }

    public function initialize()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->socket === false)
        {
            return false;
        }

        $success = socket_bind($this->socket, $this->hostIP, $this->port);
        if (!$success)
        {
            socket_close($this->socket);
            return false;
        }

        $success = socket_listen($this->socket, 1);
        if (!$success)
        {
            socket_close($this->socket);
            return false;
        }

        return true;
    }

    public function shutDown()
    {
        socket_close($this->socket);
    }

    public function acceptConnection()
    {
        $client = socket_accept($this->socket);
        if ($client === false)
        {
            return null;
        }

        return new ServerSocketConnection($client);
    }
}

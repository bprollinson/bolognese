<?php

class ClientSocketConnection
{
    private $hostIP;
    private $port;
    private $socket;

    public function __construct($hostIP, $port)
    {
        $this->hostIP = $hostIP;
        $this->port = $port;
    }

    public function open()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->socket === false)
        {
            return false;
        }

        $success = socket_connect($this->socket, $this->hostIP, $this->port);
        if (!$success)
        {
            socket_close($this->socket);
            return false;
        }

        return true;
    }

    public function read()
    {
        $buffer = '';
        socket_recv($this->socket, $buffer, 2048, MSG_WAITALL);

        return $buffer;
    }

    public function write($message)
    {
        socket_send($this->socket, $message, strlen($message), 0);
    }

    public function close()
    {
        socket_close($this->socket);
    }
}

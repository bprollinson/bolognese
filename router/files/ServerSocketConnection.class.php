<?php

class ServerSocketConnection
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function read()
    {
        return socket_read($this->client, 2048);
    }

    public function write($string)
    {
        socket_write($this->client, $string); 
    }

    public function close()
    {
        socket_close($this->client);
    }
}

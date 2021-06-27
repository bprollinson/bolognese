<?php

class DatabaseClientClient
{
    private $hostIP;
    private $port;

    public function __construct($hostIP, $port)
    {
        $this->hostIP = $hostIP;
        $this->port = $port;
    }

    public function selectScalar($sql)
    {
        $connection = new ClientSocketConnection($this->hostIP, $this->port);
        if (!$connection->open())
        {
            throw new DatabaseFailureException();
        }

        $requestParameters = [
            'type' => 'select_scalar',
            'query' => $sql
        ];
        $message = json_encode($requestParameters);
        $connection->write($message);

        $response = $connection->read();
        $connection->close();

        $responseJson = json_decode($response, true);

        return $responseJson['result'];
    }
}

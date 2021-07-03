<?php

require_once('vendor/bprollinson/bolognese-socket-client/src/ClientSocketConnection.class.php');
require_once('vendor/bprollinson/bolognese-database-client-api/src/DatabaseFailureException.class.php');

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
        return $this->runQuery('select_scalar', $sql);
    }

    public function select($sql)
    {
        return $this->runQuery('select', $sql);
    }

    public function selectSingleRow($sql)
    {
        return $this->runQuery('select_single_row', $sql);
    }

    public function insert($sql)
    {
        return $this->runQuery('insert', $sql);
    }

    public function execute($sql)
    {
        return $this->runQuery('execute', $sql);
    }

    private function runQuery($type, $sql)
    {
        $connection = new ClientSocketConnection($this->hostIP, $this->port);
        if (!$connection->open())
        {
            throw new DatabaseFailureException();
        }

        $requestParameters = [
            'type' => $type,
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

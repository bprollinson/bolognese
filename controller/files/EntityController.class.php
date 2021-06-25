<?php

require_once('ClientSocketConnection.class.php');
require_once('MethodInvoked.class.php');

class EntityController
{
    public function countEntities()
    {
        $hostIP = gethostbyname('database_client');
        $port = 50002;
        $connection = new ClientSocketConnection($hostIP, $port);
        if (!$connection->open())
        {
            return new MethodInvoked('entity_fetched', 0);
        }

        $requestParameters = [
            'type' => 'select_scalar',
            'query' => 'SELECT COUNT(1) FROM entity'
        ];
        $message = json_encode($requestParameters);
        $connection->write($message);

        $response = $connection->read();
        $connection->close();

        $responseJson = json_decode($response, true);

        return new MethodInvoked('entites_counted', $responseJson['result']);
    }

    public function getEntity()
    {
        $hostIP = gethostbyname('database_client');
        $port = 50002;
        $connection = new ClientSocketConnection($hostIP, $port);
        if (!$connection->open())
        {
            return new MethodInvoked('entity_fetched', 0);
        }

        $requestParameters = [
            'type' => 'select_scalar',
            'query' => 'SELECT COUNT(1) FROM entity'
        ];
        $message = json_encode($requestParameters);
        $connection->write($message);

        $response = $connection->read();
        $connection->close();

        $responseJson = json_decode($response, true);

        return new MethodInvoked('entity_fetched', $responseJson['result']);
    }

    public function createEntity()
    {
        return new MethodInvoked('entity_created', 1);
    }
}

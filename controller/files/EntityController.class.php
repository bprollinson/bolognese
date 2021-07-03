<?php

require_once('DatabaseClientClient.class.php');
require_once('vendor/bprollinson/bolognese-controller-api/src/MethodInvoked.class.php');
require_once('vendor/bprollinson/bolognese-database-client-api/src/DatabaseFailureException.class.php');

class EntityController
{
    private $databaseClientClient;

    public function __construct()
    {
        $hostIP = gethostbyname('database_client');
        $port = 50002;
        $this->databaseClientClient = new DatabaseClientClient($hostIP, $port);
    }

    public function countEntities($parameterValues, $getValues, $postValues)
    {
        try
        {
            $count = (int)$this->databaseClientClient->selectScalar('SELECT COUNT(1) FROM entity');
            return new MethodInvoked('entities_counted', $count);
        }
        catch (DatabaseFailureException $dfe)
        {
            return new MethodInvoked('entities_counted', 0);
        }
    }

    public function getEntities($parameterValues, $getValues, $postValues)
    {
        try
        {
            $entities = $this->databaseClientClient->select('SELECT id, name FROM entity');
            return new MethodInvoked('entities_fetched', $entities);
        }
        catch (DatabaseFailureException $dfe)
        {
            return new MethodInvoked('entities_fetched', []);
        }
    }

    public function getEntity($parameterValues, $getValues, $postValues)
    {
        try
        {
            $id = $parameterValues['id'];
            $entity = $this->databaseClientClient->selectSingleRow("SELECT id, name FROM entity WHERE id = {$id}");
            if ($entity === null)
            {
                return new MethodInvoked('entity_not_found', $entity);
            }
            return new MethodInvoked('entity_fetched', $entity);
        }
        catch (DatabaseFailureException $dfe)
        {
            return new MethodInvoked('entity_fetched', null);
        }
    }

    public function createEntity($parameterValues, $getValues, $postValues)
    {
        try
        {
            $name = $postValues['name'];
            $id = $this->databaseClientClient->insert("INSERT INTO entity(name) VALUES ('{$name}')");
            $entity = $this->databaseClientClient->selectSingleRow("SELECT id, name FROM entity WHERE id = {$id}");
            return new MethodInvoked('entity_created', $entity);
        }
        catch (DatabaseFailureException $dfe)
        {
            return new MethodInvoked('entity_created', null);
        }
    }

    public function deleteEntity($parameterValues, $getValues, $postValues)
    {
        try
        {
            $id = $parameterValues['id'];
            $entity = $this->databaseClientClient->selectSingleRow("SELECT id, name FROM entity WHERE id = {$id}");
            if ($entity === null)
            {
                return new MethodInvoked('entity_not_found', $entity);
            }

            $this->databaseClientClient->execute("DELETE FROM entity WHERE id = {$id}");
            return new MethodInvoked('entity_deleted', $entity);
        }
        catch (DatabaseFailureException $dfe)
        {
            return new MethodInvoked('entity_deleted', null);
        }
    }
}

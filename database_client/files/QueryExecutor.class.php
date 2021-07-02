<?php

require_once('vendor/bprollinson/bolognese-database-client-lib/src/DatabaseConnectionConfig.class.php');
require_once('vendor/bprollinson/bolognese-database-client-api/src/QueryExecuted.class.php');

class QueryExecutor
{
    private $databaseConnectionConfig;

    public function __construct(DatabaseConnectionConfig $databaseConnectionConfig)
    {
        $this->databaseConnectionConfig = $databaseConnectionConfig;
    }

    public function execute(QueryExecution $execution)
    {
        $host = $this->databaseConnectionConfig->getHost();
        $db = $this->databaseConnectionConfig->getDB();
        $user = $this->databaseConnectionConfig->getUser();
        $password = $this->databaseConnectionConfig->getPassword();

        $pdo = new PDO("mysql:host={$host};dbname={$db}", $user, $password);
        $statement = $pdo->prepare($execution->getQuery());
        $statement->execute();

        $type = $execution->getType();

        switch ($type)
        {
            case 'select_scalar':
                return new QueryExecuted($type, $statement->fetchColumn());
            case 'select':
                return new QueryExecuted($type, $statement->fetchAll(PDO::FETCH_ASSOC));
            case 'select_single_row':
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                if ($result === false)
                {
                    $result = null;
                }
                return new QueryExecuted($type, $result);
            case 'insert':
                return new QueryExecuted($type, $pdo->lastInsertId());
            case 'execute':
                return new QueryExecuted($type, true);
            default:
                return null;
        }
    }
}

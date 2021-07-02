<?php

require_once('vendor/bprollinson/bolognese-database-client-api/src/QueryExecuted.class.php');

class QueryExecutor
{
    public function execute(QueryExecution $execution)
    {
        $host = 'database';
        $db = 'webapp';
        $user = 'root';
        $password = '';

        $pdo = new PDO("mysql:host={$host};dbname={$db}", $user, $password);
        $statement = $pdo->prepare($execution->getQuery());
        $statement->execute();

        $type = $execution->getType();

        switch ($execution->getType())
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

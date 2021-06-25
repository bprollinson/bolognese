<?php

require_once('ScalarSelectExecuted.class.php');

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

        switch ($execution->getType())
        {
            case 'select_scalar':
                return new ScalarSelectExecuted($statement->fetchColumn());
            case 'select_single_row':
                return new ScalarSelectExecuted($statement->fetch(PDO::FETCH_ASSOC));
            case 'insert':
                return new ScalarSelectExecuted($pdo->lastInsertId());
            default:
                return null;
        }
    }
}

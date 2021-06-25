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

        return new ScalarSelectExecuted($statement->fetchColumn());
    }
}

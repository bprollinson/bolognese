<?php

require_once('vendor/bprollinson/bolognese-socket-server/src/ServerSocketProvider.class.php');
require_once('vendor/bprollinson/bolognese-database-client-api/src/QueryExecution.class.php');
require_once('QueryExecutor.class.php');

$hostIP = gethostbyname('database_client');
$port = 50002;
$socketProvider = new ServerSocketProvider($hostIP, $port);
if (!$socketProvider->initialize())
{
    die;
}

$queryExecutor = new QueryExecutor();

while (true)
{
    $client = $socketProvider->acceptConnection();
    if ($client === null)
    {
        $socketProvider->shutDown();
        die;
    }

    $request = $client->read();
    $requestParameters = json_decode($request, true);

    $requestModel = new QueryExecution($requestParameters['type'], $requestParameters['query']);

    $responseModel = $queryExecutor->execute($requestModel);
    $response = json_encode($responseModel->toArray());
    $client->write($response);

    $client->close();
}

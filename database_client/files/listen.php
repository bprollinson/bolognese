<?php

require_once('SocketProvider.class.php');
require_once('QueryExecution.class.php');
require_once('QueryExecutor.class.php');

$hostIP = gethostbyname('database_client');
$port = 50002;
$socketProvider = new SocketProvider($hostIP, $port);
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

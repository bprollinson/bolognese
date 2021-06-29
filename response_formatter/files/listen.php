<?php

require_once('ServerSocketProvider.class.php');
require_once('MethodInvoked.class.php');
require_once('ResponseFormatter.class.php');

$hostIP = gethostbyname('response_formatter');
$port = 50003;
$socketProvider = new ServerSocketProvider($hostIP, $port);
if (!$socketProvider->initialize())
{
    die;
}

$responseFormatter = new ResponseFormatter();

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

    $requestModel = new MethodInvoked(
        $requestParameters['response'],
        $requestParameters['response_value']
    );

    $responseModel = $responseFormatter->format($requestModel);
    $response = json_encode($responseModel->toArray());
    $client->write($response);

    $client->close();
}

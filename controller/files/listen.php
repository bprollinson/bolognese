<?php

require_once('SocketProvider.class.php');
require_once('MethodInvocation.class.php');
require_once('MethodInvoker.class.php');

$hostIP = gethostbyname('controller');
$port = 50001;
$socketProvider = new SocketProvider($hostIP, $port);
if (!$socketProvider->initialize())
{
    die;
}

$methodInvoker = new MethodInvoker();

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

    $requestModel = new MethodInvocation(
        $requestParameters['hostname'],
        $requestParameters['namespace'],
        $requestParameters['class'],
        $requestParameters['method']
    );

    $responseModel = $methodInvoker->invoke($requestModel);
    $response = json_encode($responseModel->toArray());
    $client->write($response);

    $client->close();
}

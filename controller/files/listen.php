<?php

require_once('vendor/bprollinson/bolognese-socket-server/src/ServerSocketProvider.class.php');
require_once('MethodInvocation.class.php');
require_once('MethodInvoker.class.php');

$hostIP = gethostbyname('controller');
$port = 50001;
$socketProvider = new ServerSocketProvider($hostIP, $port);
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
        $requestParameters['method'],
        $requestParameters['parameter_values'],
        $requestParameters['get_values'],
        $requestParameters['post_values']
    );

    $responseModel = $methodInvoker->invoke($requestModel);
    $response = json_encode($responseModel->toArray());
    $client->write($response);

    $client->close();
}

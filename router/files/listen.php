<?php

require_once('vendor/bprollinson/bolognese-socket-server/src/ServerSocketProvider.class.php');
require_once('vendor/bprollinson/bolognese-router-api/src/Request.class.php');
require_once('vendor/bprollinson/bolognese-router-lib/src/Router.class.php');
require_once('vendor/bprollinson/bolognese-router-api/src/RouteNotFoundResponse.class.php');
require_once('vendor/bprollinson/bolognese-router-api/src/MethodInvocationResponse.class.php');

$hostIP = gethostbyname('router');
$port = 50000;
$socketProvider = new ServerSocketProvider($hostIP, $port);
if (!$socketProvider->initialize())
{
    die;
}

$router = new Router('/root/routes.json');

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

    $requestModel = new Request(
        $requestParameters['method'],
        $requestParameters['uri'],
        $requestParameters['get'],
        $requestParameters['post']
    );

    $methodInvocation = $router->route($requestModel);
    if ($methodInvocation === null)
    {
        $responseModel = new RouteNotFoundResponse();
        $response = json_encode($responseModel->toArray());
        $client->write($response);
        $client->close();
        continue; 
    }

    $responseModel = new MethodInvocationResponse($methodInvocation);
    $response = json_encode($responseModel->toArray());
    $client->write($response);

    $client->close();
}

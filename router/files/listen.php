<?php

require_once('Request.class.php');
require_once('Router.class.php');
require_once('RouteNotFoundResponse.class.php');
require_once('MethodInvocationResponse.class.php');

if (!($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)))
{
    socket_close($socket);
    die;
}

$hostIP = gethostbyname('router');
if (!socket_bind($socket, $hostIP, 50000))
{
    socket_close($socket);
    die;
}

if (!socket_listen($socket, 1))
{
    socket_close($socket);
    die;
}

$router = new Router('/root/routes.json');

while (true)
{
    if (!($client = socket_accept($socket)))
    {
        socket_close($socket);
        die;
    }

    $request = socket_read($client, 2048);
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
        socket_write($client, $response);
        socket_close($client);
        continue; 
    }

    $responseModel = new MethodInvocationResponse($methodInvocation);
    $response = json_encode($responseModel->toArray());
    socket_write($client, $response);

    socket_close($client);
}

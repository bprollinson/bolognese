<?php

require_once('Request.class.php');
require_once('Router.class.php');
require_once('RouteNotFoundResponse.class.php');
require_once('MethodInvocationResponse.class.php');

class SocketProvider
{
    private $hostIP;
    private $port;
    private $socket;

    public function __construct($hostIP, $port)
    {
        $this->hostIP = $hostIP;
        $this->port = $port;
    }

    public function initialize()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->socket === false)
        {
            return false;
        }

        $success = socket_bind($this->socket, $this->hostIP, $this->port);
        if (!$success)
        {
            socket_close($this->socket);
            return false;
        }

        $success = socket_listen($this->socket, 1);
        if (!$success)
        {
            socket_close($this->socket);
            return false;
        }

        return true;
    }

    public function shutDown()
    {
        socket_close($this->socket);
    }

    public function acceptConnection()
    {
        $client = socket_accept($this->socket);
        if ($client === false)
        {
            return null;
        }

        return new SocketConnection($client);
    }
}

class SocketConnection
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function read()
    {
        return socket_read($this->client, 2048);
    }

    public function write($string)
    {
        socket_write($this->client, $string); 
    }

    public function close()
    {
        socket_close($this->client);
    }
}

$hostIP = gethostbyname('router');
$port = 50000;
$socketProvider = new SocketProvider($hostIP, $port);
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

<?php

require_once('ClientSocketConnection.class.php');

$hostIP = gethostbyname('router');
$port = 50000;
$connection = new ClientSocketConnection($hostIP, $port);
if (!$connection->open())
{
    http_response_code(502);
    die;
}

$requestParameters = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'uri' => $_SERVER['REQUEST_URI'],
    'get' => $_GET,
    'post' => $_POST
];
$message = json_encode($requestParameters);
$connection->write($message);

$response = $connection->read();

if ($response === null)
{
    socket_close($socket);
    http_response_code(502);
    die;
}

$connection->close();

$responseJson = json_decode($response, true);
if ($responseJson['response'] == 'failure')
{
    http_response_code(404);
    die;
}

echo $response;

$hostIP = gethostbyname('controller');
$port = 50001;
$connection = new ClientSocketConnection($hostIP, $port);

if (!$connection->open())
{
    http_response_code(502);
    die;
}

$requestParameters = $responseJson['body'];
$message = json_encode($requestParameters);
$connection->write($message);

$response = $connection->read();

echo $response;

$connection->close();

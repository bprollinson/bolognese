<?php

require_once('ClientSocketConnection.class.php');

$hostIP = gethostbyname('router');
$connection = new ClientSocketConnection($hostIP, 50000);
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

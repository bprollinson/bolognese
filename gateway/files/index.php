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
$post = json_decode(file_get_contents('php://input'), true);
$requestParameters = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'uri' => $_SERVER['REQUEST_URI'],
    'get' => $_GET,
    'post' => $post
];
$message = json_encode($requestParameters);
$connection->write($message);

$response = $connection->read();

if ($response === null)
{
    $connection->close();
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

$hostIP = gethostbyname($responseJson['body']['hostname']);
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

if ($response === null)
{
    $connection->close();
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

$hostIP = gethostbyname('response_formatter');
$port = 50003;
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

if ($response === null)
{
    $connection->close();
    http_response_code(502);
    die;
}

$connection->close();

$responseJson = json_decode($response, true);
if ($responseJson['response'] == 'failure')
{
    http_response_code(502);
    die;
}

http_response_code($responseJson['body']['status_code']);
if ($responseJson['body']['response_value'] !== null)
{
    echo $responseJson['body']['response_value'];
}

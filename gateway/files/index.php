<?php

if (!($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)))
{
    http_response_code(502);
    die;
}

$hostIP = gethostbyname('router');

if (!($result = socket_connect($socket, $hostIP, 50000)))
{
    socket_close($socket);
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
socket_send($socket, $message, strlen($message), 0);

$buffer = '';
socket_recv($socket, $buffer, 2048, MSG_WAITALL);

if ($buffer === null)
{
    socket_close($socket);
    http_response_code(502);
    die;
}

socket_close($socket);

$bufferJson = json_decode($buffer, true);
if ($bufferJson['response'] == failure)
{
    http_response_code(404);
    die;
}

echo $buffer;

<?php

echo 'Listening';
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

if (!($client = socket_accept($socket)))
{
    socket_close($socket);
    die;
}

$request = socket_read($client, 2048);

$responseParameters = [
    'controller' => 'SampleControler',
    'method' => 'sampleMethod'
];
$response = json_encode($responseParameters);
socket_write($client, $response);

socket_close($client);
socket_close($socket);

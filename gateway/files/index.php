<?php

class ClientSocketConnection
{
    private $hostIP;
    private $port;
    private $socket;

    public function __construct($hostIP, $port)
    {
        $this->hostIP = $hostIP;
        $this->port = $port;
    }

    public function open()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->socket === false)
        {
            return false;
        }

        $success = socket_connect($this->socket, $this->hostIP, 50000);
        if (!$success)
        {
            socket_close($this->socket);
            return false;
        }

        return true;
    }

    public function read()
    {
        $buffer = '';
        socket_recv($this->socket, $buffer, 2048, MSG_WAITALL);

        return $buffer;
    }

    public function write($message)
    {
        socket_send($this->socket, $message, strlen($message), 0);
    }

    public function close()
    {
        socket_close($this->socket);
    }
}

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

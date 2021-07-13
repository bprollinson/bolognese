<?php

require_once('vendor/bprollinson/bolognese-socket-server/src/ServerSocketProvider.class.php');
require_once('vendor/bprollinson/bolognese-controller-api/src/MethodInvoked.class.php');
require_once('vendor/bprollinson/bolognese-response-formatter-lib/src/ResponseFormatter.class.php');

$hostIP = gethostbyname('response_formatter');
$port = 50003;
$socketProvider = new ServerSocketProvider($hostIP, $port);
if (!$socketProvider->initialize())
{
    die;
}

$responseMappingFileContents = file_get_contents('/root/response_mapping.json');
$responseMapping = json_decode($responseMappingFileContents, true);
$responseFormatter = new ResponseFormatter($responseMapping);

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

    $requestModel = new MethodInvoked(
        $requestParameters['response'],
        $requestParameters['response_value']
    );

    $responseModel = $responseFormatter->format($requestModel);
    $response = json_encode($responseModel->toArray());
    $client->write($response);

    $client->close();
}

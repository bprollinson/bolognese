<?php

require_once('vendor/bprollinson/bolognese-controller-api/src/MethodInvoked.class.php');
require_once('ResponseFormatted.class.php');
require_once('HTTPResponse.class.php');

class ResponseFormatter
{
    public function format(MethodInvoked $methodInvoked)
    {
        switch ($methodInvoked->getResponse())
        {
            case 'entities_counted':
            case 'entities_fetched':
            case 'entity_fetched':
                $httpStatusCode = 200;
                break;
            case 'entity_created':
                $httpStatusCode = 201;
                break;
            case 'entity_not_found':
                $httpStatusCode = 404;
                break;
            default:
                $httpStatusCode = 200;
                break;
        }

        $responseHeaders = [
            'Content-Type' => 'application/json'
        ];
        $responseBody = json_encode($methodInvoked->getResponseValue());
        $httpResponse = new HTTPResponse($httpStatusCode, $responseHeaders, $responseBody);

        return new ResponseFormatted($httpResponse);
    }
}

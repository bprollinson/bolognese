<?php

require_once('MethodInvoked.class.php');
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
                $httpResponse = new HTTPResponse(200, json_encode($methodInvoked->getResponseValue())); 
                break;
            case 'entity_created':
                $httpResponse = new HTTPResponse(201, json_encode($methodInoked->getResponseValue()));
            default:
                $httpResponse = new HTTPResponse(200, json_encode($methodInvoked->getResponseValue()));
        }

        return new ResponseFormatted($httpResponse);
    }
}

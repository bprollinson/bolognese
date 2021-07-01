<?php

require_once('vendor/bprollinson/bolognese-response-formatter-api/src/HTTPResponse.class.php');

class ResponseFormatted
{
    private $httpResponse;

    public function __construct(HTTPResponse $httpResponse) 
    {
        $this->httpResponse = $httpResponse;
    }

    public function toArray()
    {
        return [
            'response' => 'success',
            'body' => $this->httpResponse->toArray()
        ];
    }
}

<?php

require_once('HTTPResponse.class.php');

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

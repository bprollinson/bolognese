<?php

class HTTPResponse
{
    private $statusCode;
    private $responseValue;

    public function __construct($statusCode, $responseValue)
    {
        $this->statusCode = $statusCode;
        $this->responseValue = $responseValue;
    }

    public function toArray()
    {
        return [
            'status_code' => $this->statusCode,
            'response_value' => $this->responseValue
        ];
    }
}

<?php

class HTTPResponse
{
    private $statusCode;
    private $responseHeaders;
    private $responseValue;

    public function __construct($statusCode, $responseHeaders, $responseValue)
    {
        $this->statusCode = $statusCode;
        $this->responseHeaders = $responseHeaders;
        $this->responseValue = $responseValue;
    }

    public function toArray()
    {
        return [
            'status_code' => $this->statusCode,
            'response_headers' => $this->responseHeaders,
            'response_value' => $this->responseValue
        ];
    }
}

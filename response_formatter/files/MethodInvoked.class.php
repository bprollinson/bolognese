<?php

class MethodInvoked
{
    private $response;
    private $responseValue;

    public function __construct($response, $responseValue)
    {
        $this->response = $response;
        $this->responseValue = $responseValue;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getResponseValue()
    {
        return $this->responseValue;
    }

    public function toArray()
    {
        return [
            'response' => $this->response,
            'response_value' => $this->responseValue
        ];
    }
}

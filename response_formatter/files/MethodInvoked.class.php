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

    public function toArray()
    {
        return [
            'response' => $this->response,
            'responseValue' => $this->responseValue
        ];
    }
}

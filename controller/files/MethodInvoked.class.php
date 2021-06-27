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
            'response_value' => $this->responseValue
        ];
    }
}

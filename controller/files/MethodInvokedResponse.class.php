<?php

class MethodInvokedResponse
{
    private $methodInvoked;

    public function __construct(MethodInvoked $methodInvoked)
    {
        $this->methodInvoked = $methodInvoked;
    }

    public function toArray()
    {
        return [
            'response' => 'success',
            'body' => $this->methodInvoked->toArray()
        ];
    }
}

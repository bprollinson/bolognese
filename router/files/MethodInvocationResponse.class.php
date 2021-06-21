<?php

class MethodInvocationResponse
{
    private $methodInvocation;

    public function __construct(MethodInvocation $methodInvocation)
    {
        $this->methodInvocation = $methodInvocation;
    }

    public function toArray()
    {
        return [
            'response' => 'success',
            'body' => $this->methodInvocation->toArray()
        ];
    }
}

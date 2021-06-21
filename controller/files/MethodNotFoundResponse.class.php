<?php

class MethodNotFoundResponse
{
    public function toArray()
    {
        return [
            'response' => 'failure',
            'error' => 'method_not_found'
        ];
    }
}

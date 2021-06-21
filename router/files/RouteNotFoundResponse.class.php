<?php

class RouteNotFoundResponse
{
    public function toArray()
    {
        return [
            'response' => 'failure',
            'error' => 'route_not_found'
        ];
    }
}

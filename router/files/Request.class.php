<?php

class Request
{
    private $method;
    private $uri;
    private $get;
    private $post;

    public function __construct($method, $uri, $get, $post)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->get = $get;
        $this->post = $post;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getURI()
    {
        return $this->uri;
    }
}

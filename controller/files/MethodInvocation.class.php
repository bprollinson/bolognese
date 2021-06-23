<?php

class MethodInvocation
{
    private $hostname;
    private $namespace;
    private $class;
    private $method;

    public function __construct($hostname, $namespace, $class, $method)
    {
        $this->hostname = $hostname;
        $this->namespace = $namespace;
        $this->class = $class;
        $this->method = $method;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function toArray()
    {
        return [
            'hostname' => $this->hostname,
            'namespace' => $this->namespace,
            'class' => $this->class,
            'method' => $this->method
        ];
    }
}

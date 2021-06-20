<?php

class MethodInvocation
{
    private $namespace;
    private $class;
    private $method;

    public function __construct($namespace, $class, $method)
    {
        $this->namespace = $namespace;
        $this->class = $class;
        $this->method = $method;
    }

    public function toArray()
    {
        return [
            'namespace' => $this->namespace,
            'class' => $this->class,
            'method' => $this->method
        ];
    }
}

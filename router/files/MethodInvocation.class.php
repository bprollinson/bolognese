<?php

class MethodInvocation
{
    private $hostname;
    private $namespace;
    private $class;
    private $method;
    private $parameterValues;
    private $getValues;
    private $postValues;

    public function __construct($hostname, $namespace, $class, $method, $parameterValues, $getValues, $postValues)
    {
        $this->hostname = $hostname;
        $this->namespace = $namespace;
        $this->class = $class;
        $this->method = $method;
        $this->parameterValues = $parameterValues;
        $this->getValues = $getValues;
        $this->postValues = $postValues;
    }

    public function toArray()
    {
        return [
            'hostname' => $this->hostname,
            'namespace' => $this->namespace,
            'class' => $this->class,
            'method' => $this->method,
            'parameter_values' => $this->parameterValues,
            'get_values' => $this->getValues,
            'post_values' => $this->postValues
        ];
    }
}

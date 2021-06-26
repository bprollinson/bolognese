<?php

class MethodInvocation
{
    private $hostname;
    private $namespace;
    private $class;
    private $method;
    private $parameterValues;

    public function __construct($hostname, $namespace, $class, $method, $parameterValues)
    {
        $this->hostname = $hostname;
        $this->namespace = $namespace;
        $this->class = $class;
        $this->method = $method;
        $this->parameterValues = $parameterValues;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParameterValues()
    {
        return $this->parameterValues;
    }

    public function toArray()
    {
        return [
            'hostname' => $this->hostname,
            'namespace' => $this->namespace,
            'class' => $this->class,
            'method' => $this->method,
            'parameter_values' => $this->parameterValues
        ];
    }
}

<?php

require_once('MethodInvoked.class.php');
require_once('MethodNotFoundResponse.class.php');
require_once('MethodInvokedResponse.class.php');

class MethodInvoker
{
    public function invoke(MethodInvocation $methodInvocation)
    {
        $class = $methodInvocation->getClass();
        $classFileName = "{$class}.class.php";

        if (file_exists($classFileName))
        {
            $methodInvoked = new MethodInvoked('entity_created', 1);
            return new MethodInvokedResponse($methodInvoked);
        }

        return new MethodNotFoundResponse();
    }
}

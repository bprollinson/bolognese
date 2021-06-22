<?php

require_once('MethodInvoked.class.php');

class MethodInvoker
{
    public function invoke(MethodInvocation $methodInvocation)
    {
        return new MethodInvoked('entity_created', 1);
    }
}

<?php

require_once('MethodInvoked.class.php');

class EntityController
{
    public function getEntity()
    {
        return new MethodInvoked('entity_fetched', 1);
    }
}

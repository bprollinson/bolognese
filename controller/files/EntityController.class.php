<?php

require_once('MethodInvoked.class.php');

class EntityController
{
    public function getEntity()
    {
        return new MethodInvoked('entity_fetched', 1);
    }

    public function createEntity()
    {
        return new MethodInvoked('entity_created', 1);
    }
}

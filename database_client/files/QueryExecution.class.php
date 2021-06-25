<?php

class QueryExecution
{
    private $type;
    private $query;

    public function __construct($type, $query)
    {
        $this->type = $type;
        $this->query = $query;
    }

    public function getQuery()
    {
        return $this->query;
    }
}

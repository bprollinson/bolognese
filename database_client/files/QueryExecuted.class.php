<?php

class QueryExecuted
{
    private $type;
    private $result;

    public function __construct($type, $result)
    {
        $this->type = $type;
        $this->result = $result;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'result' => $this->result
        ];
    }
}

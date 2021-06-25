<?php

class ScalarSelectExecuted
{
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function toArray()
    {
        return [
            'type' => 'select_scalar',
            'result' => $this->result
        ];
    }
}

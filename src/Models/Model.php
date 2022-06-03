<?php

namespace Src\Models;

class Model
{
    protected $tableName;

    protected $writable = [];

    public function getWritables()
    {
        return $this->writable;
    }
}
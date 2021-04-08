<?php

namespace Records;

use JsonSerializable;

class tickettypes implements JsonSerializable
{
    /** @var int */
    public $id;
    /** @var string */
    public $name;
    /** @var double */
    public $price;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

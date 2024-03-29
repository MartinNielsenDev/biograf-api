<?php

namespace Records;

use JsonSerializable;

class genres implements JsonSerializable
{
    /** @var int */
    public $id;
    /** @var string */
    public $name;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

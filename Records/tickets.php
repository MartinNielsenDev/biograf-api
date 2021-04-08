<?php

namespace Records;

use JsonSerializable;

class tickets implements JsonSerializable
{
    /** @var int */
    public $id;
    /** @var int */
    public $isPaid;
    /** @var int */
    public $userId;
    /** @var int */
    public $showId;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

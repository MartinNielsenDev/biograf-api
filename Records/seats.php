<?php

namespace Records;

use JsonSerializable;

class seats implements JsonSerializable
{
    /** @var int */
    public $id;
    /** @var int */
    public $x;
    /** @var int */
    public $y;
    /** @var int */
    public $threaterId;
    /** @var int */
    public $ticketId;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

<?php

namespace Records;

use JsonSerializable;

class seats implements JsonSerializable
{
    /** @var int */
    public $id;
    /** @var int */
    public $location;
    /** @var int */
    public $threaterId;
    /** @var int */
    public $ticketId;
    /** @var bool */
    public $isBooked;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

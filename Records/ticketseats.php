<?php

namespace Records;

use JsonSerializable;

class ticketseats implements JsonSerializable
{
    /** @var int */
    public $id;
    /** @var int */
    public $ticketId;
    /** @var int */
    public $seatId;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

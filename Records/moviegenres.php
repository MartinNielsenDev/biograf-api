<?php

namespace Records;

use JsonSerializable;

class moviegenres implements JsonSerializable
{
    /** @var int */
    public $genreId;
    /** @var int */
    public $movieId;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

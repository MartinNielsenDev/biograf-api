<?php

namespace Records;

use JsonSerializable;

class movies implements JsonSerializable
{
    /** @var int */
    public $id;
    /** @var string */
    public $title;
    /** @var string */
    public $description;
    /** @var double */
    public $rating;
    /** @var int */
    public $length;
    /** @var string */
    public $posterUrl;
    /** @var string */
    public $trailerUrl;
    /** @var int */
    public $releaseDate;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

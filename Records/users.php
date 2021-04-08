<?php

namespace Records;

use JsonSerializable;

class users implements JsonSerializable
{
    /** @var int */
    public $id;
    /** @var int */
    public $email;
    /** @var string */
    public $password;
    /** @var string */
    public $name;
    /** @var string */
    public $address;
    /** @var int */
    public $postCodeId;
    /** @var string */
    public $phoneNumber;
    /** @var int */
    public $privileges;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

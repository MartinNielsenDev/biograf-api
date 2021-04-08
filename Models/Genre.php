<?php

namespace Models;

use JsonSerializable;

class Genre implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

<?php

namespace Records;

use JsonSerializable;

class postcodes implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var int */
    private $postCode;
    /** @var string */
    private $cityName;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPostCode(): int
    {
        return $this->postCode;
    }

    /**
     * @param int $postCode
     */
    public function setPostCode(int $postCode): void
    {
        $this->postCode = $postCode;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @param string $cityName
     */
    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

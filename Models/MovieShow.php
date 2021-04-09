<?php

namespace Models;

use JsonSerializable;

class MovieShow implements JsonSerializable
{
    /** @var int */
    private $time;
    /** @var bool */
    private $title;
    /** @var int */
    private $length;
    /** @var string */
    private $theater;

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime(int $time): void
    {
        $this->time = $time;
    }

    /**
     * @return bool
     */
    public function isTitle(): bool
    {
        return $this->title;
    }

    /**
     * @param bool $title
     */
    public function setTitle(bool $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getTheater(): string
    {
        return $this->theater;
    }

    /**
     * @param string $theater
     */
    public function setTheater(string $theater): void
    {
        $this->theater = $theater;
    }


    public function jsonSerialize()
    {
        // convert datetime to timestamp
        $timestamp = strtotime($this->getTime());
        $this->setTime($timestamp);

        return get_object_vars($this);
    }
}

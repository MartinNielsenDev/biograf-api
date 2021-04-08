<?php

namespace Models;

use JsonSerializable;

class Show implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var int */
    private $time;
    /** @var int */
    private $theaterId;
    /** @var int */
    private $movieId;

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
     * @return int
     */
    public function getTheaterId(): int
    {
        return $this->theaterId;
    }

    /**
     * @param int $theaterId
     */
    public function setTheaterId(int $theaterId): void
    {
        $this->theaterId = $theaterId;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @param int $movieId
     */
    public function setMovieId(int $movieId): void
    {
        $this->movieId = $movieId;
    }


    public function jsonSerialize()
    {
        // convert datetime to timestamp
        $timestamp = strtotime($this->getTime());
        $this->setTime($timestamp);

        return get_object_vars($this);
    }
}

<?php

namespace Models;

use JsonSerializable;

class Seat implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var int */
    private $location;
    /** @var int */
    private $theaterId;
    /** @var int|null */
    private $ticketId;
    /** @var bool */
    private $isBooked;

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
    public function getLocation(): int
    {
        return $this->location;
    }

    /**
     * @param int $location
     */
    public function setLocation(int $location): void
    {
        $this->location = $location;
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
     * @return int|null
     */
    public function getTicketId(): ?int
    {
        return $this->ticketId;
    }

    /**
     * @param int|null $ticketId
     */
    public function setTicketId(?int $ticketId): void
    {
        $this->ticketId = $ticketId;
    }

    /**
     * @return bool
     */
    public function isBooked(): bool
    {
        return $this->isBooked;
    }

    /**
     * @param bool $isBooked
     */
    public function setIsBooked(bool $isBooked): void
    {
        $this->isBooked = $isBooked;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

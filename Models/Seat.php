<?php

namespace Models;

use JsonSerializable;

class Seat implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var int */
    private $x;
    /** @var int */
    private $y;
    /** @var int */
    private $theaterId;
    /** @var bool */
    private $isReserved;

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
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
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
    public function isReserved(): bool
    {
        return $this->isReserved;
    }

    /**
     * @param bool $isReserved
     */
    public function setIsReserved(bool $isReserved): void
    {
        $this->isReserved = $isReserved;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

<?php

namespace Models;

use JsonSerializable;

class TicketSeat implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var int */
    private $ticketId;
    /** @var int */
    private $seatId;

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
    public function getTicketId(): int
    {
        return $this->ticketId;
    }

    /**
     * @param int $ticketId
     */
    public function setTicketId(int $ticketId): void
    {
        $this->ticketId = $ticketId;
    }

    /**
     * @return int
     */
    public function getSeatId(): int
    {
        return $this->seatId;
    }

    /**
     * @param int $seatId
     */
    public function setSeatId(int $seatId): void
    {
        $this->seatId = $seatId;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

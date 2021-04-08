<?php

namespace Models;

use JsonSerializable;

class Ticket implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var bool */
    private $isPaid;
    /** @var int */
    private $userId;
    /** @var int */
    private $show;
    /** @var int[] */
    private $seats;

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
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->isPaid;
    }

    /**
     * @param bool $isPaid
     */
    public function setIsPaid(bool $isPaid): void
    {
        $this->isPaid = $isPaid;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getShow(): int
    {
        return $this->show;
    }

    /**
     * @param int $show
     */
    public function setShow(int $show): void
    {
        $this->show = $show;
    }

    /**
     * @return int[]
     */
    public function getSeats(): array
    {
        return $this->seats;
    }

    /**
     * @param int[] $seats
     */
    public function setSeats(array $seats): void
    {
        $this->seats = $seats;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

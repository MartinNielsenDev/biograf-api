<?php

namespace Models;

use JsonSerializable;

class AuthUser implements JsonSerializable
{
    /** @var string */
    private $email;
    /** @var string */
    private $name;
    /** @var int */
    private $issued_at;
    /** @var int */
    private $expiration;
    /** @var string */
    private $issuer;
    /** @var int */
    private $privileges;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
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

    /**
     * @return int
     */
    public function getIssuedAt(): int
    {
        return $this->issued_at;
    }

    /**
     * @param int $issued_at
     */
    public function setIssuedAt(int $issued_at): void
    {
        $this->issued_at = $issued_at;
    }

    /**
     * @return int
     */
    public function getExpiration(): int
    {
        return $this->expiration;
    }

    /**
     * @param int $expiration
     */
    public function setExpiration(int $expiration): void
    {
        $this->expiration = $expiration;
    }

    /**
     * @return string
     */
    public function getIssuer(): string
    {
        return $this->issuer;
    }

    /**
     * @param string $issuer
     */
    public function setIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
    }

    /**
     * @return int
     */
    public function getPrivileges(): int
    {
        return $this->privileges;
    }

    /**
     * @param int $privileges
     */
    public function setPrivileges(int $privileges): void
    {
        $this->privileges = $privileges;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

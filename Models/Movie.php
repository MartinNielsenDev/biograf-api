<?php

namespace Models;

use JsonSerializable;

class Movie implements JsonSerializable
{
    /** @var int */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $description;
    /** @var string[] */
    private $genres;
    /** @var double */
    private $rating;
    /** @var int */
    private $length;
    /** @var string */
    private $posterUrl;
    /** @var string */
    private $trailerUrl;
    /** @var int */
    private $releaseDate;
    /** @var string */
    private $ticketType;
    /** @var double */
    private $price;

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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string[]
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @param string[] $genres
     */
    public function setGenres(array $genres): void
    {
        $this->genres = $genres;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating(float $rating): void
    {
        $this->rating = $rating;
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
    public function getPosterUrl(): string
    {
        return $this->posterUrl;
    }

    /**
     * @param string $posterUrl
     */
    public function setPosterUrl(string $posterUrl): void
    {
        $this->posterUrl = $posterUrl;
    }

    /**
     * @return string
     */
    public function getTrailerUrl(): string
    {
        return $this->trailerUrl;
    }

    /**
     * @param string $trailerUrl
     */
    public function setTrailerUrl(string $trailerUrl): void
    {
        $this->trailerUrl = $trailerUrl;
    }


    /**
     * @return int
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param int $releaseDate
     */
    public function setReleaseDate(int $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return string
     */
    public function getTicketType(): string
    {
        return $this->ticketType;
    }

    /**
     * @param string $ticketType
     */
    public function setTicketType(string $ticketType): void
    {
        $this->ticketType = $ticketType;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }


    public function jsonSerialize()
    {
        // convert datetime to timestamp
        $timestamp = strtotime($this->getReleaseDate());
        $this->setReleaseDate($timestamp);

        return get_object_vars($this);
    }
}

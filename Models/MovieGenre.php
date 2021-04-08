<?php

namespace Models;

use JsonSerializable;

class MovieGenre implements JsonSerializable
{
    /** @var int */
    private $genreId;
    /** @var int */
    private $movieId;

    /**
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

    /**
     * @param int $genreId
     */
    public function setGenreId(int $genreId): void
    {
        $this->genreId = $genreId;
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
        return get_object_vars($this);
    }
}

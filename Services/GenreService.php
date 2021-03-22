<?php

namespace Services;

use Records\genres;

class GenreService
{
    /** @var QueryService */
    private $query_service;

    public function __construct(QueryService $query_service)
    {
        $this->query_service = $query_service;
    }

    public function getGenres(): array
    {
        return $this->query_service->selectRecords
        (
            genres::class,
            'SELECT id, name FROM genres'
        );
    }
}

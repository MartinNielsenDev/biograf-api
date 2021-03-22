<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface;
use Services\GenreService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class GenreController extends ControllerBase
{
    private $user_service;

    public function __construct(
        GenreService $genre_service
    )
    {
        $this->user_service = $genre_service;
    }

    public function getGenres(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $genres = $this->user_service->getGenres();
        return $this->json($genres);
    }
}

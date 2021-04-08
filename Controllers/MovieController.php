<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface;
use Services\MovieService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class MovieController extends ControllerBase
{
    private $movie_service;

    public function __construct(
        MovieService $movie_service
    )
    {
        $this->movie_service = $movie_service;
    }

    public function postMovie(Request $request, Response $response)
    {
//        $this->setResponse($response);

//        try {
//            $array = $request->getParsedBody();
//            $movie = $this->movie_service->createMovie($array);
//        } catch (TypeError $e) {
//            return $this->badRequest();
//        }
//
//        if ($movie === null) {
//            return $this->badRequest();
//        } else {
//            return $this->created($movie);
//        }
    }

    public function getShow(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $movie = $this->movie_service->getShow($params['show_id']);
        if ($movie === null) {
            return $this->notFound();
        }
        return $this->json($movie);
    }

    public function getShows(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $params = $request->getQueryParams();

        if (!isset($params['movie_id'])) {
            return $this->notFound();
        }
        $shows = $this->movie_service->getShows($params['movie_id']);

        return $this->json($shows);
    }

    public function getMovie(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $movie = $this->movie_service->getMovie($params['movie_id']);
        if ($movie === null) {
            return $this->notFound();
        }
        return $this->json($movie);
    }

    public function getMovies(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $movies = $this->movie_service->getMovies();
        return $this->json($movies);
    }

    public function deleteMovie(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $is_deleted = $this->movie_service->deleteMovie($params['movie_id']);

        if ($is_deleted === null) {
            return $this->badRequest();
        } else if ($is_deleted <= 0) {
            return $this->notFound();
        }

        return $this->ok();
    }
}

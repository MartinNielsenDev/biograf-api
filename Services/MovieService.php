<?php

namespace Services;

use Models\Genre;
use Models\Movie;
use Models\Show;

class MovieService
{
    /** @var QueryService */
    private $query_service;

    public function __construct(QueryService $query_service)
    {
        $this->query_service = $query_service;
    }

    private function toModel(array $array): Movie
    {
        $model = new Movie();
        $model->setId($array['id']);
        $model->setTitle($array['title']);
        $model->setDescription($array['description']);
        $model->setGenres($array['genres']);
        $model->setRating($array['rating']);
        $model->setLength($array['length']);
        $model->setPosterUrl($array['posterUrl']);
        $model->setTrailerUrl($array['trailerUrl']);
        $model->setReleaseDate($array['releaseDate']);
        $model->setTicketType($array['ticketType']);

        return $model;
    }

    public function createMovie(array $array): ?Movie
    {
//        for ($y = 1; $y <= 8; $y++) {
//            for ($x = 1; $x <= 10; $x++) {
//                $this->query_service->insertRecord("INSERT INTO seats(x, y, theaterId) VALUES (?, ?, ?)", [$x, $y, 2]);
//            }
//        }
//        if (!isset($array['email']) || !isset($array['password']) || !isset($array['name']) || !isset($array['address']) || !isset($array['postCode']) || !isset($array['phoneNumber'])) {
//            return null;
//        }
//        $user = $this->toModel($array);
//        $password_hash = password_hash($array['password'], PASSWORD_DEFAULT);
//
//        /** @var postcodes|null $postCode */
//        $postCode = $this->query_service->selectRecord(postcodes::class, 'SELECT id, postCode, cityName FROM postcodes WHERE postCode = ?', [$user->getPostCode()]);
//        if ($postCode === null) {
//            return null;
//        }
//
//        /** @var Movie|null $user */
//        $id = $this->query_service->insertRecord(
//            'INSERT INTO users(email, password, name, address, postCodeId, phoneNumber) VALUES (?, ?, ?, ?, ?, ?)',
//            [$user->getEmail(), $password_hash, $user->getName(), $user->getAddress(), $postCode->getId(), $user->getPhoneNumber()]
//        );
//        if ($id !== null) {
//            $user->setId($id);
//
//            return $user;
//        } else {
//            return null;
//        }
    }

    public function getShow(int $show_id): ?Show
    {
        /** @var Show|null $show */
        $show = $this->query_service->selectRecord
        (
            Show::class,
            'SELECT shows.id, shows.time, shows.theaterId, shows.movieId FROM shows WHERE id = ?',
            [$show_id]
        );

        return $show;
    }

    public function getShows(int $movie_id): array
    {
        return $this->query_service->selectRecords
        (
            Show::class,
            'SELECT shows.id, shows.time, shows.theaterId, shows.movieId FROM shows WHERE movieId = ?',
            [$movie_id]
        );
    }

    public function getMovie(int $movie_id): ?Movie
    {
        $movieGenres = $this->query_service->selectRecords
        (
            Genre::class,
            'SELECT genres.id, genres.name FROM moviegenres, genres WHERE genres.id = moviegenres.genreId && movieId = ?',
            [$movie_id]
        );
        $genres = [];
        /** @var Genre $genre */
        foreach ($movieGenres as $genre) {
            $genres[] = $genre->getName();
        }
        /** @var Movie|null $movie */
        $movie = $this->query_service->selectRecord
        (
            Movie::class,
            'SELECT movies.id, movies.title, movies.description, movies.rating, movies.length, movies.posterUrl, movies.trailerUrl, movies.releaseDate, tickettypes.name AS ticketType, tickettypes.price AS price FROM movies, tickettypes WHERE movies.id = ? && movies.ticketType = tickettypes.id',
            [$movie_id]
        );
        if ($movie !== null) {
            $movie->setGenres($genres);
        }
        return $movie;
    }

    public function getMovies(): array
    {
        $movies = $this->query_service->selectRecords
        (
            Movie::class,
            'SELECT movies.id, movies.title, movies.description, movies.rating, movies.length, movies.posterUrl, movies.trailerUrl, movies.releaseDate, tickettypes.name AS ticketType, tickettypes.price AS price FROM movies, tickettypes WHERE movies.ticketType = tickettypes.id'
        );
        foreach ($movies as $movie) {
            /** @var Movie $movie */
            $movieGenres = $this->query_service->selectRecords
            (
                Genre::class,
                'SELECT genres.id, genres.name FROM moviegenres, genres WHERE genres.id = moviegenres.genreId && movieId = ?',
                [$movie->getId()]
            );
            $genres = [];
            /** @var Genre $genre */
            foreach ($movieGenres as $genre) {
                $genres[] = $genre->getName();
            }
            $movie->setGenres($genres);
        }
        return $movies;
    }

    public function deleteMovie(int $movie_id): ?int
    {
        return $this->query_service->deleteRecord('movies', $movie_id);
    }
}

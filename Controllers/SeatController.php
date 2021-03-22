<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface;
use Services\SeatService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TypeError;

class SeatController extends ControllerBase
{
    private $seat_service;

    public function __construct(
        SeatService $genre_service
    )
    {
        $this->seat_service = $genre_service;
    }

    public function getSeats(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $seats = $this->seat_service->getSeats();
        return $this->json($seats);
    }

    public function putSeat(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        try {
            $array = $request->getParsedBody();
            $seat = $this->seat_service->putSeat($array);

            if ($seat === null) {
                return $this->badRequest();
            }
        } catch (TypeError $e) {
            return $this->badRequest();
        }

        return $this->json($seat);
    }
}

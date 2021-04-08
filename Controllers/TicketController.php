<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface;
use Services\TicketService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TypeError;

class TicketController extends ControllerBase
{
    private $ticket_service;

    public function __construct(
        TicketService $ticket_service
    )
    {
        $this->ticket_service = $ticket_service;
    }

    public function postTicket(Request $request, Response $response)
    {
        $this->setResponse($response);

        try {
            $array = $request->getParsedBody();

            $user = $this->ticket_service->createTicket($array);
        } catch (TypeError $e) {
            return $this->badRequest();
        }

        if ($user === null) {
            return $this->badRequest();
        } else {
            return $this->created($user);
        }
    }

    public function getTicket(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $user = $this->ticket_service->getTicket($params['ticket_id']);
        if ($user === null) {
            return $this->notFound();
        }
        return $this->json($user);
    }

    public function getTickets(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $users = $this->ticket_service->getTickets();
        return $this->json($users);
    }

    public function deleteTicket(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $is_deleted = $this->ticket_service->deleteTicket($params['user_id']);

        if ($is_deleted === null) {
            return $this->badRequest();
        } else if ($is_deleted <= 0) {
            return $this->notFound();
        }

        return $this->ok();
    }
}

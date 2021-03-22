<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface;
use Services\UserService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TypeError;

class UserController extends ControllerBase
{
    private $user_service;

    public function __construct(
        UserService $user_service
    )
    {
        $this->user_service = $user_service;
    }

    public function postUser(Request $request, Response $response)
    {
        $this->setResponse($response);

        try {
            $array = $request->getParsedBody();
            $user = $this->user_service->createUser($array);
        } catch (TypeError $e) {
            return $this->badRequest();
        }

        if ($user === null) {
            return $this->badRequest();
        } else {
            return $this->created($user);
        }
    }

    public function getUser(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $user = $this->user_service->getUser($params['user_id']);
        if ($user === null) {
            return $this->notFound();
        }
        return $this->json($user);
    }

    public function getUsers(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $users = $this->user_service->getUsers();
        return $this->json($users);
    }

    public function deleteUser(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        $is_deleted = $this->user_service->deleteUser($params['user_id']);

        if ($is_deleted === null) {
            return $this->badRequest();
        } else if ($is_deleted <= 0) {
            return $this->notFound();
        }

        return $this->ok();
    }
}

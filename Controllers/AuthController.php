<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface;
use Services\AuthService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TypeError;

class AuthController extends ControllerBase
{
    private $auth_service;

    public function __construct(
        AuthService $auth_service
    )
    {
        $this->auth_service = $auth_service;
    }

    public function postLogin(Request $request, Response $response, array $params): ResponseInterface
    {
        $this->setResponse($response);

        try {
            $array = $request->getParsedBody();
            $token = $this->auth_service->getToken($array);
        } catch (TypeError $e) {
            return $this->unauthorized();
        }

        if ($token === null) {
            return $this->unauthorized();
        }
        return $this->json($token);
    }
}

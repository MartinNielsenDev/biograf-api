<?php

namespace Middlewares;

use Controllers\ControllerBase;
use Lib\CurrentUser;
use Models\AuthUser;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class UserAuthMiddleware extends ControllerBase
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $helper = new \PsrJwt\Helper\Request();
        $payload = $helper->getParsedToken($request, 'jwt')->getPayload();

        $current_user = new AuthUser();
        $current_user->setEmail($payload['sub']);
        $current_user->setName($payload['name']);
        $current_user->setIssuedAt($payload['iat']);
        $current_user->setIssuer($payload['iss']);
        $current_user->setExpiration($payload['exp']);
        $current_user->setPrivileges($payload['privileges']);

        CurrentUser::$current_user = $current_user;

        return $handler->handle($request);
    }
}

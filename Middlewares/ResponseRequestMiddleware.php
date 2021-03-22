<?php

namespace Middlewares;

use Controllers\ControllerBase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ResponseRequestMiddleware extends ControllerBase
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = $handler->handle($request);
        $this->setResponse($response);
    }
}

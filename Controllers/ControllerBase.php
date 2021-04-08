<?php

namespace Controllers;

use Lmc\HttpConstants\Header;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class ControllerBase
{
    /**
     * @var ServerRequestInterface
     */
    private $request;
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    protected function ok($content = null): ResponseInterface
    {
        if ($content === null) {
            return $this->noContent();
        } else {
            return $this->json($content);
        }
    }

    protected function json($content, $status = 200): ResponseInterface
    {
        $json = json_encode($content);
        $this->response = $this->response
            ->withStatus($status)
            ->withHeader(Header::CONTENT_TYPE, 'application/json; charset=utf-8');
        $this->response->getBody()->write($json);
        return $this->response;
    }

    protected function created($content = null)
    {
        $this->response = $this->response->withStatus(201);

        if ($content !== null) {
            return $this->json($content, 201);
        }
        return $this->response;
    }

    protected function noContent(): ResponseInterface
    {
        return $this->response->withStatus(204);
    }

    protected function badRequest(): ResponseInterface
    {
        return $this->response->withStatus(400);
    }

    protected function unauthorized(): ResponseInterface
    {
        return $this->response->withStatus(401);
    }

    protected function forbidden(): ResponseInterface
    {
        return $this->response->withStatus(403);
    }

    protected function notFound(): ResponseInterface
    {
        return $this->response->withStatus(404);
    }

    protected function methodNotAllowed(): ResponseInterface
    {
        return $this->response->withStatus(405);
    }

    protected function conflict($reason): ResponseInterface
    {
        return $this->json($reason)->withStatus(409);
    }

    protected function internalServerError(): ResponseInterface
    {
        return $this->response->withStatus(500);
    }

    protected function notImplemented(): ResponseInterface
    {
        $this->response = $this->response->withStatus(501);

        return $this->response;
    }
}

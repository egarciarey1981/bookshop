<?php

declare(strict_types=1);

namespace App\Actions;

use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Bookshop\Shared\Domain\Exception\DomainRecordNotFoundException;

abstract class Action
{
    protected Request $request;
    protected Response $response;
    protected array $args;
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    abstract protected function action(): Response;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            return $this->respond(404);
        }
    }

    protected function where(): void
    {
        var_dump($this->args);
        var_dump($this->request->getQueryParams());
        var_dump($this->request->getParsedBody());
        var_dump($this->request->getUploadedFiles());
        var_dump($this->request->getCookieParams());
        var_dump($this->request->getAttributes());
        var_dump($this->request->getServerParams());
        var_dump($this->request->getHeaders());
        var_dump($this->request->getUri());
    }

    protected function queryString(string $key, mixed $default = null): mixed
    {
        $queryParams = $this->request->getQueryParams();

        if (!isset($queryParams[$key])) {
            return $default;
        }

        return $queryParams[$key];
    }

    protected function postParam(string $key, mixed $default = null): mixed
    {
        $parsedBody = (array)$this->request->getParsedBody();

        if (!isset($parsedBody[$key])) {
            return $default;
        }

        return $parsedBody[$key];
    }

    protected function putParam(string $key, mixed $default = null): mixed
    {
        $parsedBody = json_decode(file_get_contents('php://input'), true);

        if (!isset($parsedBody[$key])) {
            return $default;
        }

        return $parsedBody[$key];        
    }

    protected function resolveArg(string $name)
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    protected function respond(int $statusCode = 200): Response
    {
        return $this->response->withStatus($statusCode);
    }

    protected function respondWithData(array $data = [], int $statusCode = 200, array $headers = []): Response
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);

        $this->response = $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);

        foreach ($headers as $key => $value) {
            $this->response = $this->response->withHeader($key, $value);
        }

        return $this->response;
    }
}
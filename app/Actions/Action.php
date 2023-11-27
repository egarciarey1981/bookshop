<?php

declare(strict_types=1);

namespace App\Actions;

use Bookshop\Catalog\Domain\Exception\DomainDoesNotExistException;
use Bookshop\Catalog\Domain\Exception\DomainException;
use Exception;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

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
        } catch (DomainDoesNotExistException $e) {
            $this->logger->error(static::class . ': ' . $e->getMessage());
            return $this->respondWithData([], 404);
        } catch (DomainException $e) {
            $this->logger->error(static::class . ': ' . $e->getMessage());
            return $this->respondWithData(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            $this->logger->error(static::class . ': ' . $e->getMessage());
            return $this->respond(500);
        }
    }

    protected function queryString(string $key, mixed $default = null): mixed
    {
        $queryParams = $this->request->getQueryParams();

        if (!isset($queryParams[$key])) {
            return $default;
        }

        return $queryParams[$key];
    }

    protected function formParam(string $key, mixed $default = null): mixed
    {
        $parsedBody = (array)$this->request->getParsedBody();

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
        return $this->respondWithData([], $statusCode);
    }

    protected function respondWithData(array $data = [], int $statusCode = 200, array $headers = []): Response
    {
        $playload['status'] = $statusCode;
        $playload['data'] = $data;

        if (isset($playload['data']['error'])) {
            $playload['error'] = $playload['data']['error'];
            unset($playload['data']['error']);
        }

        if ($playload['data'] === []) {
            unset($playload['data']);
        }

        $json = json_encode($playload, JSON_PRETTY_PRINT);
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

<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\Create\CreateGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Create\CreateGenreService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CreateGenreAction extends Action
{
    private CreateGenreService $service;

    public function __construct(
        LoggerInterface $logger,
        CreateGenreService $service,
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $name = (string)$this->formParam('name', '');

        $request = new CreateGenreRequest($name);
        $response = $this->service->execute($request);

        $id = $response->id();
        $headers['Location'] = "/genres/$id";

        $this->logger->info("Genre of id `$id` was created.");

        return $this->respondWithData([], 201, $headers);
    }
}

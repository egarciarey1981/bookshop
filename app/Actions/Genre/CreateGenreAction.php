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
        $genreName = (string)$this->formParam('name', '');

        $request = new CreateGenreRequest($genreName);
        $response = $this->service->execute($request);

        $data['genre'] = $response->genre();
        $headers['Location'] = sprintf('/genres/%s', $data['genre']['id']);

        $this->logger->info(
            sprintf("Genre of id `%s` was created.", $data['genre']['id'])
        );

        return $this->respondWithData($data, 201, $headers);
    }
}

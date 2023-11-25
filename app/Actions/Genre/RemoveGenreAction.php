<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\Remove\RemoveGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Remove\RemoveGenreService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class RemoveGenreAction extends Action
{
    private RemoveGenreService $service;

    public function __construct(
        LoggerInterface $logger,
        RemoveGenreService $service,
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $genreId = $this->resolveArg('id');

        $request = new RemoveGenreRequest($genreId);
        $this->service->execute($request);

        $this->logger->info(
            sprintf("Genre of id `%s` was removed.", $genreId)
        );

        return $this->respond(204);
    }
}

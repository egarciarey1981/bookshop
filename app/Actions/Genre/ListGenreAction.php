<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\ListGenreService;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class ListGenreAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly ListGenreService $listGenresService,
    ) {
    }

    public function action(): Response
    {
        $response = $this->listGenresService->execute(
            (int) $this->queryString('offset', 0),
            (int) $this->queryString('limit', 10),
            $this->queryString('filter', '')
        );

        $this->logger->info("Genres list was viewed.");

        return $this->respondWithData($response);
    }
}

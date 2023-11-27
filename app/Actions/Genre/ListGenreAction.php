<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\List\ListGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\List\ListGenreService;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class ListGenreAction extends Action
{
    private ListGenreService $service;

    public function __construct(
        LoggerInterface $logger,
        ListGenreService $service,
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $offset = (int)$this->queryString('offset', 0);
        $limit = (int)$this->queryString('limit', 10);
        $filter = (string)$this->queryString('filter', '');

        $request = new ListGenreRequest($offset, $limit, $filter);
        $response = $this->service->execute($request);

        $data = [
            'total' => $response->total(),
            'genres' => $response->genres(),
        ];

        $this->logger->info("Genres list was viewed.");

        return $this->respondWithData($data);
    }
}

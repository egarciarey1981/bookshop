<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\ListBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ListBooksAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly ListBookService $listBookService,
    ) {
    }

    public function action(): Response
    {
        $response = $this->listBookService->execute(
            (int) $this->queryString('offset', 0),
            (int) $this->queryString('limit', 10),
            $this->queryString('filter', '')
        );

        $this->logger->info("Books list was viewed.");

        return $this->respondWithData($response);
    }
}

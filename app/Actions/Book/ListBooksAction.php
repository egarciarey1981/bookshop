<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\List\ListBooksRequest;
use Bookshop\Catalog\Application\Book\List\ListBooksService;

class ListBooksAction extends BookAction
{
    public function action(): Response
    {
        $listBooksService = new ListBooksService(
            $this->bookRepository
        );

        $listBookResponse = $listBooksService(
            new ListBooksRequest(
                (int) $this->queryString('offset', 0),
                (int) $this->queryString('limit', 10),
                $this->queryString('filter', ''),
            )
        );

        $data = $listBookResponse->books();

        $this->logger->info("Books list was viewed.");

        return $this->respondWithData($data);
    }
}
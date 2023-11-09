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
        $offset = (int) $this->queryString('offset', 0);
        $limit = (int) $this->queryString('limit', 10);
        $filter = $this->queryString('filter', '');

        $listBookResquest = new ListBooksRequest($offset, $limit, $filter);
        $listBooksService = new ListBooksService($this->bookRepository);
        $listBookResponse = $listBooksService($listBookResquest);

        $response['data']['total'] = $listBookResponse->total();
        $response['data']['books'] = $listBookResponse->books();

        $this->logger->info("Books list was viewed.");

        return $this->respondWithData($response['data']);
    }
}

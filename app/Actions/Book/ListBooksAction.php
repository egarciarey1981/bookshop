<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\List\ListBookRequest;
use Bookshop\Catalog\Application\Service\Book\List\ListBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ListBooksAction extends Action
{
    private ListBookService $service;

    public function __construct(
        LoggerInterface $logger,
        ListBookService $service
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $offset = (int)$this->queryString('offset', 0);
        $limit = (int)$this->queryString('limit', 10);
        $filter = (string)$this->queryString('filter', '');

        $request = new ListBookRequest($offset, $limit, $filter);
        $response = $this->service->execute($request);

        $this->logger->info("Books list was viewed.");

        $data = [
            'total' => $response->total(),
            'books' => $response->books(),
        ];

        return $this->respondWithData($data);
    }
}

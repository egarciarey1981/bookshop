<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\List\ListBooksRequest;
use Bookshop\Catalog\Application\Book\List\ListBooksService;
use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\Genre\GenreRepository;
use Psr\Log\LoggerInterface;

class ListBooksAction extends BookAction
{
    private GenreRepository $genreRepository;

    public function __construct(
        LoggerInterface $logger,
        BookRepository $bookRepository,
        GenreRepository $genreRepository,
    ) {
        parent::__construct($logger, $bookRepository);
        $this->genreRepository = $genreRepository;
    }

    public function action(): Response
    {
        $listBooksService = new ListBooksService(
            $this->bookRepository,
            $this->genreRepository,
        );

        $listBookResponse = $listBooksService(
            new ListBooksRequest(
                (int) $this->queryString('offset', 0),
                (int) $this->queryString('limit', 10),
                $this->queryString('filter', ''),
            )
        );

        $data = [
            'total' => $listBookResponse->total(),
            'books' => $listBookResponse->books(),
        ];

        $this->logger->info("Books list was viewed.");

        return $this->respondWithData($data);
    }
}

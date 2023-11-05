<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\List\ListBooksRequest;
use Bookshop\Catalog\Application\Book\List\ListBooksService;
use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\BookGenre\BookGenreRepository;
use Bookshop\Catalog\Domain\Genre\Genre;
use Bookshop\Catalog\Domain\Genre\GenreRepository;
use Psr\Log\LoggerInterface;

class ListBooksAction extends BookAction
{
    private BookGenreRepository $bookGenreRepository;
    private GenreRepository $genreRepository;

    public function __construct(
        LoggerInterface $logger,
        BookRepository $bookRepository,
        BookGenreRepository $bookGenreRepository,
        GenreRepository $genreRepository,
    ) {
        parent::__construct($logger, $bookRepository);
        $this->bookGenreRepository = $bookGenreRepository;
        $this->genreRepository = $genreRepository;
    }

    public function action(): Response
    {
        $listBooksService = new ListBooksService(
            $this->bookRepository,
            $this->bookGenreRepository,
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

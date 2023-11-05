<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\View\ViewBookRequest;
use Bookshop\Catalog\Application\Book\View\ViewBookService;
use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\BookGenre\BookGenreRepository;
use Bookshop\Catalog\Domain\Genre\GenreRepository;
use Psr\Log\LoggerInterface;

class ViewBookAction extends BookAction
{
    private GenreRepository $genreRepository;
    private BookGenreRepository $bookGenreRepository;

    public function __construct(
        LoggerInterface $logger,
        BookRepository $bookRepository,
        GenreRepository $genreRepository,
        BookGenreRepository $bookGenreRepository,
    )
    {
        parent::__construct($logger, $bookRepository);
        $this->genreRepository = $genreRepository;
        $this->bookGenreRepository = $bookGenreRepository;
    }

    public function action(): Response
    {
        $id = $this->resolveArg('id');

        $viewBooksService = new ViewBookService(
            $this->bookRepository,
            $this->genreRepository,
            $this->bookGenreRepository,
        );

        $listBookResponse = $viewBooksService(
            new ViewBookRequest($id)
        );

        $this->logger->info("Book of id `$id` was viewed.");

        return $this->respondWithData([
            'book' => $listBookResponse->book()
        ]);
    }
}
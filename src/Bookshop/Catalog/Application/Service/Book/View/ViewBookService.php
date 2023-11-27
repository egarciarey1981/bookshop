<?php

namespace Bookshop\Catalog\Application\Service\Book\View;

use Bookshop\Catalog\Application\Service\Book\View\ViewBookRequest;
use Bookshop\Catalog\Application\Service\Book\View\ViewBookResponse;
use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;

class ViewBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(ViewBookRequest $request): ViewBookResponse
    {
        $bookId = new BookId($request->bookId());

        $book = $this->bookRepository->ofBookId($bookId);

        if (null === $book) {
            throw new BookDoesNotExistException();
        }

        return new ViewBookResponse(
            $book->bookId()->value(),
            $book->bookTitle()->value(),
            array_map(
                fn ($genre) => [
                    'id' => $genre->genreId()->value(),
                    'name' => $genre->genreName()->value(),
                ],
                $book->bookGenres()
            ),
        );
    }
}

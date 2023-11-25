<?php

namespace Bookshop\Catalog\Application\Service\Book\View;

use Bookshop\Catalog\Application\Service\Book\View\ViewBookRequest;
use Bookshop\Catalog\Application\Service\Book\View\ViewBookResponse;
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
        return new ViewBookResponse($book->toArray());
    }
}

<?php

namespace Bookshop\Catalog\Application\Book\Delete;

use Bookshop\Catalog\Domain\Book\BookRepository;

class DeleteBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    
    public function __invoke(DeleteBookRequest $request)
    {
        $this->bookRepository->delete(
            $request->bookId()
        );
    }
}

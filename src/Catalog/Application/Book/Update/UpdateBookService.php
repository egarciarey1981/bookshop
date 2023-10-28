<?php

namespace Bookshop\Catalog\Application\Book\Update;

use Bookshop\Catalog\Domain\Book\BookRepository;

class UpdateBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    
    public function __invoke(UpdateBookRequest $request)
    {
        $this->bookRepository->update(
            $request->book()
        );
    }
}

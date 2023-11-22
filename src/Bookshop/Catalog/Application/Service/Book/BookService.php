<?php

namespace Bookshop\Catalog\Application\Service\Book;

use Bookshop\Catalog\Domain\Model\Book\BookRepository;

abstract class BookService
{
    public function __construct(
        protected readonly BookRepository $bookRepository
    ) {
    }
}

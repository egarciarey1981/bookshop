<?php

namespace Bookshop\Catalog\Domain\Book;

use Bookshop\Catalog\Domain\Book\BookId;
use Bookshop\Shared\Domain\Exception\DomainRecordNotFoundException;

class BookDoesNotExistException extends DomainRecordNotFoundException
{
    public function __construct(BookId $id)
    {
        parent::__construct(sprintf('The book `%s` does not exist', $id->value()));
    }
}
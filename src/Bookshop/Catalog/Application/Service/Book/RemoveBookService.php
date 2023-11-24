<?php

namespace Bookshop\Catalog\Application\Service\Book;

use Bookshop\Catalog\Domain\Event\Book\BookRemovedEvent;
use Bookshop\Catalog\Domain\Event\DomainEventPublisher;
use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Exception;

class RemoveBookService
{
    public function __construct(
        private readonly DomainEventPublisher $domainEventPublisher,
        private readonly BookRepository $bookRepository
    ) {
    }

    public function execute(string $bookId): void
    {
        $book = $this->bookRepository->ofBookId(
            new BookId($bookId)
        );

        if ($book === null) {
            throw new BookDoesNotExistException(
                sprintf('Book with id `%s` does not exist', $bookId)
            );
        }

        if ($this->bookRepository->remove($book) === false) {
            throw new Exception('Book could not be removed');
        }

        $this->domainEventPublisher->publish(
            new BookRemovedEvent($book->bookId())
        );
    }
}

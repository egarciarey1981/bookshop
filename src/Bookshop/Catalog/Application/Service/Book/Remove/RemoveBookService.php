<?php

namespace Bookshop\Catalog\Application\Service\Book\Remove;

use Bookshop\Catalog\Application\Service\Book\Remove\RemoveBookRequest;
use Bookshop\Catalog\Domain\Event\Book\BookRemovedEvent;
use Bookshop\Catalog\Domain\Event\DomainEventPublisher;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;

class RemoveBookService
{
    private DomainEventPublisher $domainEventPublisher;
    private BookRepository $bookRepository;

    public function __construct(
        DomainEventPublisher $domainEventPublisher,
        BookRepository $bookRepository
    ) {
        $this->domainEventPublisher = $domainEventPublisher;
        $this->bookRepository = $bookRepository;
    }

    public function execute(RemoveBookRequest $request): void
    {
        $bookId = new BookId($request->bookId());
        $book = $this->bookRepository->ofBookId($bookId);
        $this->bookRepository->remove($book);

        $event = new BookRemovedEvent($book->bookId());
        $this->domainEventPublisher->publish($event);
    }
}

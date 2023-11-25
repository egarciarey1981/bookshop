<?php

namespace Bookshop\Catalog\Application\Service\Book\Update;

use Bookshop\Catalog\Application\Service\Book\Update\UpdateBookRequest;
use Bookshop\Catalog\Domain\Event\Book\BookUpdatedEvent;
use Bookshop\Catalog\Domain\Event\DomainEventPublisher;
use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class UpdateBookService
{
    private DomainEventPublisher $domainEventPublisher;
    private BookRepository $bookRepository;
    private GenreRepository $genreRepository;

    public function __construct(
        DomainEventPublisher $domainEventPublisher,
        BookRepository $bookRepository,
        GenreRepository $genreRepository,
    ) {
        $this->domainEventPublisher = $domainEventPublisher;
        $this->bookRepository = $bookRepository;
        $this->genreRepository = $genreRepository;
    }

    public function execute(UpdateBookRequest $request): void
    {
        $bookId = new BookId($request->bookId());
        $bookTitle = new BookTitle($request->bookTitle());
        $bookGenreIds = $this->genreRepository->ofGenreIds(
            array_map(
                fn (string $genreId) => new GenreId($genreId),
                $request->bookGenres()
            )
        );

        $book = new Book($bookId, $bookTitle, $bookGenreIds);
        $this->bookRepository->update($book);

        $event = new BookUpdatedEvent($book->bookId());
        $this->domainEventPublisher->publish($event);
    }
}

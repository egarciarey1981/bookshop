<?php

namespace Bookshop\Catalog\Application\Service\Book\Create;

use Bookshop\Catalog\Domain\Event\Book\BookCreatedEvent;
use Bookshop\Catalog\Domain\Event\DomainEventPublisher;
use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

final class CreateBookService
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

    public function execute(CreateBookRequest $request): CreateBookResponse
    {
        $bookId = $this->bookRepository->nextIdentity();
        $bookTitle = new BookTitle($request->bookTitle());
        $bookGenres = $this->genreRepository->ofGenreIds(
            array_map(
                fn (string $genreId) => new GenreId($genreId),
                $request->bookGenres()
            )
        );

        $book = new Book($bookId, $bookTitle, $bookGenres);
        $this->bookRepository->insert($book);

        $event = new BookCreatedEvent($book->bookId());
        $this->domainEventPublisher->publish($event);

        return new CreateBookResponse($book->toArray());
    }
}

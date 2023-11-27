<?php

namespace Bookshop\Catalog\Domain\Subscriber\Genre;

use Bookshop\Catalog\Domain\Event\Book\BookCreatedEvent;
use Bookshop\Catalog\Domain\Event\Book\BookRemovedEvent;
use Bookshop\Catalog\Domain\Event\Book\BookUpdatedEvent;
use Bookshop\Catalog\Domain\Event\DomainEvent;
use Bookshop\Catalog\Domain\Service\Genre\UpdateNumberOfBooksByGenreService;
use Bookshop\Catalog\Domain\Subscriber\DomainEventSubscriber;

final class UpdateNumberOfBooksByGenreSubscriber implements DomainEventSubscriber
{
    public function __construct(
        private readonly UpdateNumberOfBooksByGenreService $updateGenresService
    ) {
    }

    public function handle(DomainEvent $domainEvent): void
    {
        $this->updateGenresService->execute();
    }

    public function isSubscribedTo(DomainEvent $domainEvent): bool
    {
        return $domainEvent instanceof BookCreatedEvent ||
               $domainEvent instanceof BookUpdatedEvent ||
               $domainEvent instanceof BookRemovedEvent;
    }
}

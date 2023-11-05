<?php

declare(strict_types=1);

use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\BookGenre\BookGenreRepository;
use Bookshop\Catalog\Domain\Genre\GenreRepository;
use Bookshop\Catalog\Infrastructure\Persistence\Pdo\PdoBookGenreRepository;
use Bookshop\Catalog\Infrastructure\Persistence\Pdo\PdoBookRepository;
use Bookshop\Catalog\Infrastructure\Persistence\Pdo\PdoGenreRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        BookRepository::class => \DI\autowire(PdoBookRepository::class),
        GenreRepository::class => \DI\autowire(PdoGenreRepository::class),
        BookGenreRepository::class => \DI\autowire(PdoBookGenreRepository::class),
    ]);
};

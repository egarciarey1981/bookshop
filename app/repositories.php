<?php

declare(strict_types=1);

use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Bookshop\Catalog\Infrastructure\Persistence\Pdo\PdoBookRepository;
use Bookshop\Catalog\Infrastructure\Persistence\Pdo\PdoGenreRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        BookRepository::class => \DI\autowire(PdoBookRepository::class),
        GenreRepository::class => \DI\autowire(PdoGenreRepository::class),
    ]);
};

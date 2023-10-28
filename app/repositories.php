<?php

declare(strict_types=1);

use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Infrastructure\Persistence\Pdo\PdoBookRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        BookRepository::class => \DI\autowire(PdoBookRepository::class),
    ]);
};

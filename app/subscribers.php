<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Bookshop\Catalog\Domain\Subscriber\Genre\UpdateNumberOfBooksByGenreSubscriber;
use Bookshop\Catalog\Domain\Event\DomainEventPublisher;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        DomainEventPublisher::class => function (ContainerInterface $c) {
            $domainEventPublisher = DomainEventPublisher::instance();

            $domainEventPublisher->subscribe($c->get(UpdateNumberOfBooksByGenreSubscriber::class));

            return $domainEventPublisher;
        },
    ]);
};

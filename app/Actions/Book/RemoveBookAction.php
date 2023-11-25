<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\Remove\RemoveBookRequest;
use Bookshop\Catalog\Application\Service\Book\Remove\RemoveBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class RemoveBookAction extends Action
{
    private RemoveBookService $service;

    public function __construct(
        LoggerInterface $logger,
        RemoveBookService $service,
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $bookId = $this->resolveArg('id');

        $request = new RemoveBookRequest($bookId);
        $this->service->execute($request);

        $this->logger->info(
            sprintf("Book of id `%s` was removed.", $bookId)
        );

        return $this->respond();
    }
}

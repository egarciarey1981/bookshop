<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\RemoveBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class RemoveBookAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly RemoveBookService $removeBookService,
    ) {
    }

    public function action(): Response
    {
        $this->removeBookService->execute(
            $bookId = $this->resolveArg('id')
        );

        $this->logger->info(
            sprintf("Book of id `%s` was removed.", $bookId)
        );

        return $this->respond();
    }
}

<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\UpdateBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class UpdateBookAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly UpdateBookService $updateBookService,
    ) {
    }

    public function action(): Response
    {
        $this->updateBookService->execute(
            $bookId = $this->resolveArg('id'),
            $this->formParam('title', ''),
            $this->formParam('genres', [])
        );

        $this->logger->info(
            sprintf("Book of id `%s` was updated.", $bookId)
        );

        return $this->respond();
    }
}

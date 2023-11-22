<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\ViewBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ViewBookAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly ViewBookService $viewBookService,
    ) {
    }

    public function action(): Response
    {
        $book = $this->viewBookService->execute(
            $bookId = $this->resolveArg('id'),
        );

        $this->logger->info(
            sprintf('Book of id `%s` was viewed.', $bookId),
        );

        return $this->respondWithData(['book' => $book]);
    }
}

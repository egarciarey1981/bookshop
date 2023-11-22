<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\CreateBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CreateBookAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly CreateBookService $createBookService,
    ) {
    }

    public function action(): Response
    {
        $book = $this->createBookService->execute(
            $this->formParam('title', ''),
            $this->formParam('genres', [])
        );

        $this->logger->info(
            sprintf("Book of id `%s` was created.", $book['id'])
        );

        return $this->respondWithData(
            ['genre' => $book],
            201,
            ['headers' => '/genre/' . $book['id']]
        );
    }
}

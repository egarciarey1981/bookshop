<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\Update\UpdateBookRequest;
use Bookshop\Catalog\Application\Book\Update\UpdateBookService;

class UpdateBookAction extends BookAction
{
    public function action(): Response
    {
        $updateBooksService = new UpdateBookService(
            $this->bookRepository
        );

        $updateBooksService(
            new UpdateBookRequest(
                $this->resolveArg('id'),
                $this->formParam('title'),
            )
        );

        $id = $this->resolveArg('id');
        $this->logger->info("Book of id `$id` was updated.");

        return $this->respond();
    }
}

<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\Delete\DeleteBookRequest;
use Bookshop\Catalog\Application\Book\Delete\DeleteBookService;

class DeleteBookAction extends BookAction
{
    public function action(): Response
    {
        $updateBooksService = new DeleteBookService(
            $this->bookRepository
        );

        $id = $this->resolveArg('id');

        $updateBooksService(
            new DeleteBookRequest($id)
        );

        $this->logger->info("Book of id `$id` was updated.");

        return $this->respond();
    }
}

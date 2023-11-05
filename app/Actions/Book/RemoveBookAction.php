<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\Remove\RemoveBookRequest;
use Bookshop\Catalog\Application\Book\Remove\RemoveBookService;

class RemoveBookAction extends BookAction
{
    public function action(): Response
    {
        $updateBooksService = new RemoveBookService(
            $this->bookRepository
        );

        $id = $this->resolveArg('id');

        $updateBooksService(
            new RemoveBookRequest($id)
        );

        $this->logger->info("Book of id `$id` was removed.");

        return $this->respond(204);
    }
}

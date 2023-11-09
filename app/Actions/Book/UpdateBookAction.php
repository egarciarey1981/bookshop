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
        $id = $this->resolveArg('id');
        $title = $this->formParam('title', '');

        $updateBookRequest = new UpdateBookRequest($id, $title);
        $updateBookService = new UpdateBookService($this->bookRepository);
        $updateBookService($updateBookRequest);

        $this->logger->info("Book of id `$id` was updated.");

        return $this->respond();
    }
}

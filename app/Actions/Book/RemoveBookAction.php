<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Service\Book\Remove\RemoveBookRequest;
use Bookshop\Catalog\Application\Service\Book\Remove\RemoveBookService;

class RemoveBookAction extends BookAction
{
    public function action(): Response
    {
        $id = $this->resolveArg('id');

        $removeBookRequest = new RemoveBookRequest($id);
        $removeBookService = new RemoveBookService($this->bookRepository);
        $removeBookService($removeBookRequest);

        $this->logger->info("Book of id `$id` was removed.");

        return $this->respond();
    }
}

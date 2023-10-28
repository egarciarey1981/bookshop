<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\View\ViewBookRequest;
use Bookshop\Catalog\Application\Book\View\ViewBookService;

class ViewBookAction extends BookAction
{
    public function action(): Response
    {
        $id = $this->resolveArg('id');

        $viewBooksService = new ViewBookService(
            $this->bookRepository
        );

        $listBookResponse = $viewBooksService(
            new ViewBookRequest($id)
        );

        $data['book'] = $listBookResponse->book();

        $this->logger->info("Book of id `$id` was viewed.");

        return $this->respondWithData($data);
    }
}
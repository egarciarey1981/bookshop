<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\Create\CreateBookRequest;
use Bookshop\Catalog\Application\Book\Create\CreateBookService;

class CreateBookAction extends BookAction
{
    public function action(): Response
    {
        $createBooksService = new CreateBookService(
            $this->bookRepository
        );

        $createBookResponse = $createBooksService(
            new CreateBookRequest(
                $this->formParam('title', ''),
            )
        );

        $data['book'] = $createBookResponse->book();
        $id = $data['book']['id'];

        $this->logger->info("Book of id `$id` was createed.");

        return $this->respondWithData($data, 201, [
            'Location' => "/book/$id"
        ]);
    }
}

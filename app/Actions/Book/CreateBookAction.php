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
        $title = $this->formParam('title', '');

        $createBookRequest = new CreateBookRequest($title);
        $createBookService = new CreateBookService($this->bookRepository);
        $createBookResponse = $createBookService($createBookRequest);

        $response['data']['book'] = $createBookResponse->book();
        $response['headers']['Location'] = '/book/' . $response['data']['book']['id'];

        $this->logger->info('Book of id `' . $response['data']['book']['id'] . '` was created.');

        return $this->respondWithData($response['data'], 201, $response['headers']);
    }
}

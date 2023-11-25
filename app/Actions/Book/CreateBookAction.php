<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\Create\CreateBookRequest;
use Bookshop\Catalog\Application\Service\Book\Create\CreateBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CreateBookAction extends Action
{
    private CreateBookService $service;

    public function __construct(
        LoggerInterface $logger,
        CreateBookService $service,
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $bookTitle = $this->formParam('title', '');
        $bookGenres = $this->formParam('genres', []);

        $request = new CreateBookRequest($bookTitle, $bookGenres);
        $response = $this->service->execute($request);

        $data['book'] = $response->book();
        $headers['Location'] = sprintf('/book/%s', $data['book']['id']);

        $message = sprintf("Book of id `%s` was created.", $data['book']['id']);
        $this->logger->info($message);

        return $this->respondWithData($data, 201, $headers);
    }
}

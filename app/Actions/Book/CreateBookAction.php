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
        $title = $this->formParam('title', '');
        $genreIds = $this->formParam('genres', []);

        $request = new CreateBookRequest($title, $genreIds);
        $response = $this->service->execute($request);

        $id = $response->id();
        $headers['Location'] = "/book/$id";

        $this->logger->info("Book of id `$id` was created.");

        return $this->respondWithData([], 201, $headers);
    }
}

<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Book\Create\CreateBookRequest;
use Bookshop\Catalog\Application\Book\Create\CreateBookService;
use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\Genre\GenreRepository;
use Psr\Log\LoggerInterface;

class CreateBookAction extends BookAction
{
    private GenreRepository $genreRepository;

    public function __construct(
        LoggerInterface $logger,
        BookRepository $bookRepository,
        GenreRepository $genreRepository,
    ) {
        parent::__construct($logger, $bookRepository);
        $this->genreRepository = $genreRepository;
    }

    public function action(): Response
    {
        $title = $this->formParam('title', '');
        $genreIds = $this->formParam('genres', []);

        $createBookRequest = new CreateBookRequest($title, $genreIds);
        $createBookService = new CreateBookService(
            $this->bookRepository,
            $this->genreRepository,
        );
        $createBookResponse = $createBookService($createBookRequest);

        $response['data']['book'] = $createBookResponse->book();
        $response['headers']['Location'] = '/book/' . $response['data']['book']['id'];

        $this->logger->info('Book of id `' . $response['data']['book']['id'] . '` was created.');

        return $this->respondWithData($response['data'], 201, $response['headers']);
    }
}

<?php

declare(strict_types=1);

namespace App\Actions\Book;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Service\Book\Update\UpdateBookRequest;
use Bookshop\Catalog\Application\Service\Book\Update\UpdateBookService;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Psr\Log\LoggerInterface;

class UpdateBookAction extends BookAction
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
        $id = $this->resolveArg('id');
        $title = $this->formParam('title', '');
        $genreIds = $this->formParam('genres', []);

        $updateBookRequest = new UpdateBookRequest($id, $title, $genreIds);
        $updateBookService = new UpdateBookService(
            $this->bookRepository,
            $this->genreRepository,
        );
        $updateBookService($updateBookRequest);

        $this->logger->info("Book of id `$id` was updated.");

        return $this->respond();
    }
}

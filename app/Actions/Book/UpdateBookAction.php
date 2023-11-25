<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\Update\UpdateBookRequest;
use Bookshop\Catalog\Application\Service\Book\Update\UpdateBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class UpdateBookAction extends Action
{
    private UpdateBookService $service;

    public function __construct(
        LoggerInterface $logger,
        UpdateBookService $service,
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $bookId = $this->resolveArg('id');
        $bookTitle = $this->formParam('title', '');
        $bookGenres = $this->formParam('genres', []);

        $request = new UpdateBookRequest($bookId, $bookTitle, $bookGenres);
        $this->service->execute($request);

        $message = sprintf("Book of id `%s` was updated.", $bookId);
        $this->logger->info($message);

        return $this->respond();
    }
}

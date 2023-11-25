<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Book\View\ViewBookRequest;
use Bookshop\Catalog\Application\Service\Book\View\ViewBookService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ViewBookAction extends Action
{
    private ViewBookService $service;

    public function __construct(
        LoggerInterface $logger,
        ViewBookService $service,
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $bookId = $this->resolveArg('id');

        $request = new ViewBookRequest($bookId);
        $response = $this->service->execute($request);

        $message = sprintf("Book of id `%s` was viewed.", $bookId);
        $this->logger->info($message);

        $data['book'] = $response->book();
        return $this->respondWithData($data);
    }
}

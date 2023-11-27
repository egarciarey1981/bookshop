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
        $id = $this->resolveArg('id');

        $request = new ViewBookRequest($id);
        $response = $this->service->execute($request);

        $this->logger->info("Book of id `$id` was viewed.");

        $data['book'] = [
            'id' => $response->id(),
            'title' => $response->title(),
            'genres' => $response->bookGenres(),
        ];

        return $this->respondWithData($data);
    }
}

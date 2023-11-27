<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\View\ViewGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\View\ViewGenreService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ViewGenreAction extends Action
{
    private ViewGenreService $service;

    public function __construct(
        LoggerInterface $logger,
        ViewGenreService $service,
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $id = (string)$this->resolveArg('id');

        $request = new ViewGenreRequest($id);
        $response = $this->service->execute($request);

        $data['genre'] = [
            'id' => $response->id(),
            'name' => $response->name(),
            'number_of_books' => $response->numberOfBooks(),
        ];

        $this->logger->info("Genre of id `$id` was viewed.");

        return $this->respondWithData($data);
    }
}

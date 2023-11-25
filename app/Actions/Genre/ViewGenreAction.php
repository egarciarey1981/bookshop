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
        $genreId = (string)$this->resolveArg('id');

        $request = new ViewGenreRequest($genreId);
        $response = $this->service->execute($request);

        $message = sprintf("Genre of id `%s` was viewed.", $genreId);
        $this->logger->info($message);

        $data['genre'] = $response->genre();
        return $this->respondWithData($data);
    }
}

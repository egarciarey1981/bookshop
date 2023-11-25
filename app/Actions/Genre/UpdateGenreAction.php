<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\Update\UpdateGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Update\UpdateGenreService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class UpdateGenreAction extends Action
{
    private UpdateGenreService $service;

    public function __construct(
        LoggerInterface $logger,
        UpdateGenreService $service,
    ) {
        parent::__construct($logger);
        $this->service = $service;
    }

    public function action(): Response
    {
        $genreId = $this->resolveArg('id');
        $genreName = $this->formParam('name', '');

        $request = new UpdateGenreRequest($genreId, $genreName);
        $this->service->execute($request);

        $this->logger->info(
            sprintf("Genre of id `%s` was updated.", $genreId),
        );

        return $this->respond();
    }
}

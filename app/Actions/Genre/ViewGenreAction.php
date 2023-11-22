<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\ViewGenreService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ViewGenreAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly ViewGenreService $viewGenresService,
    ) {
    }

    public function action(): Response
    {
        $genre = $this->viewGenresService->execute(
            $genreId = $this->resolveArg('id')
        );

        $this->logger->info(
            sprintf("Genre of id `%s` was viewed.", $genreId)
        );

        return $this->respondWithData(['genre' => $genre]);
    }
}

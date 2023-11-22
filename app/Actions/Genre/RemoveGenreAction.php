<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\RemoveGenreService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class RemoveGenreAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly RemoveGenreService $removeGenreService,
    ) {
    }

    public function action(): Response
    {
        $this->removeGenreService->execute(
            $genreId = $this->resolveArg('id'),
        );

        $this->logger->info(
            sprintf("Genre of id `%s` was removed.", $genreId)
        );

        return $this->respond();
    }
}

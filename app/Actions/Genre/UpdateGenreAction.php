<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\UpdateGenreService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class UpdateGenreAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly UpdateGenreService $updateGenreService,
    ) {
    }

    public function action(): Response
    {
        $this->updateGenreService->execute(
            $genreId = $this->resolveArg('id'),
            $this->formParam('name', ''),
        );

        $this->logger->info(
            sprintf("Genre of id `%s` was updated.", $genreId)
        );

        return $this->respond();
    }
}

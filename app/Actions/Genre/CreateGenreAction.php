<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Application\Service\Genre\CreateGenreService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CreateGenreAction extends Action
{
    public function __construct(
        protected LoggerInterface $logger,
        private readonly CreateGenreService $createGenreService,
    ) {
    }

    public function action(): Response
    {
        $genre = $this->createGenreService->execute(
            $this->formParam('name', '')
        );

        $this->logger->info(
            sprintf("Genre of id `%s` was created.", $genre['id'])
        );

        return $this->respondWithData(
            ['genre' => $genre],
            201,
            ['headers' => '/genre/' . $genre['id']]
        );
    }
}

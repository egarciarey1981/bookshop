<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Genre\Create\CreateGenreRequest;
use Bookshop\Catalog\Application\Genre\Create\CreateGenreService;

class CreateGenreAction extends GenreAction
{
    public function action(): Response
    {
        $createGenresService = new CreateGenreService(
            $this->genreRepository
        );

        $createGenreResponse = $createGenresService(
            new CreateGenreRequest(
                $this->postParam('name'),
            )
        );

        $data['genre'] = $createGenreResponse->genre();
        $id = $data['genre']['id'];

        $this->logger->info("Genre of id `$id` was createed.");

        return $this->respondWithData($data, 201, [
            'Location' => "/genre/$id"
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Genre\List\ListGenresRequest;
use Bookshop\Catalog\Application\Genre\List\ListGenresService;

class ListGenresAction extends GenreAction
{
    public function action(): Response
    {
        $listGenresService = new ListGenresService(
            $this->genreRepository
        );

        $listGenreResponse = $listGenresService(
            new ListGenresRequest(
                (int) $this->queryString('offset', 0),
                (int) $this->queryString('limit', 10),
            )
        );

        $data['genres'] = $listGenreResponse->genres();

        $this->logger->info("Genres list was viewed.");

        return $this->respondWithData($data);
    }
}
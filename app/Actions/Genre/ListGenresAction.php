<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use Bookshop\Catalog\Application\Service\Genre\List\ListGenresRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Service\Genre\List\ListGenresService;

class ListGenresAction extends GenreAction
{
    public function action(): Response
    {
        $offset = (int) $this->queryString('offset', 0);
        $limit = (int) $this->queryString('limit', 10);
        $filter = $this->queryString('filter', '');

        $listGenreRequest = new ListGenresRequest($offset, $limit, $filter);
        $listGenresService = new ListGenresService($this->genreRepository);
        $listGenreResponse = $listGenresService($listGenreRequest);

        $response['data']['total'] = $listGenreResponse->total();
        $response['data']['genres'] = $listGenreResponse->genres();

        $this->logger->info("Genres list was viewed.");

        return $this->respondWithData($response['data']);
    }
}

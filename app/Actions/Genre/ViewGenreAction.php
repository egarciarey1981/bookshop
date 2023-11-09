<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Genre\View\ViewGenreRequest;
use Bookshop\Catalog\Application\Genre\View\ViewGenreService;

class ViewGenreAction extends GenreAction
{
    public function action(): Response
    {
        $id = $this->resolveArg('id');

        $viewGenreRequest = new ViewGenreRequest($id);
        $viewGenreService = new ViewGenreService($this->genreRepository);
        $viewGenreResponse = $viewGenreService($viewGenreRequest);

        $response['data']['genre'] = $viewGenreResponse->genre();

        $this->logger->info("Genre of id `$id` was viewed.");

        return $this->respondWithData($response['data']);
    }
}

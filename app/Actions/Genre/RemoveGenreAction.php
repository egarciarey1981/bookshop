<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Service\Genre\Remove\RemoveGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Remove\RemoveGenreService;

class RemoveGenreAction extends GenreAction
{
    public function action(): Response
    {
        $id = $this->resolveArg('id');

        $removeGenreRequest = new RemoveGenreRequest($id);
        $removeGenreService = new RemoveGenreService($this->genreRepository);
        $removeGenreService($removeGenreRequest);

        $this->logger->info("Genre of id `$id` was removed.");

        return $this->respond();
    }
}

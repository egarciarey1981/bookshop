<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Genre\Remove\RemoveGenreRequest;
use Bookshop\Catalog\Application\Genre\Remove\RemoveGenreService;

class RemoveGenreAction extends GenreAction
{
    public function action(): Response
    {
        $updateGenresService = new RemoveGenreService(
            $this->genreRepository
        );

        $id = $this->resolveArg('id');

        $updateGenresService(
            new RemoveGenreRequest($id)
        );

        $this->logger->info("Genre of id `$id` was removed.");

        return $this->respond();
    }
}

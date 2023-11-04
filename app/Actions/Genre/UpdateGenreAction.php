<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use Psr\Http\Message\ResponseInterface as Response;
use Bookshop\Catalog\Application\Genre\Update\UpdateGenreRequest;
use Bookshop\Catalog\Application\Genre\Update\UpdateGenreService;

class UpdateGenreAction extends GenreAction
{
    public function action(): Response
    {
        $updateGenresService = new UpdateGenreService(
            $this->genreRepository
        );

        $updateGenresService(
            new UpdateGenreRequest(
                $this->resolveArg('id'),
                $this->putParam('name'),
            )
        );

        $id = $this->resolveArg('id');
        $this->logger->info("Genre of id `$id` was updated.");

        return $this->respond();
    }
}

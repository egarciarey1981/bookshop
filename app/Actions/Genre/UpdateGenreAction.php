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
        $id = $this->resolveArg('id');
        $name = $this->formParam('name', '');

        $updateGenreRequest = new UpdateGenreRequest($id, $name);
        $updateGenreService = new UpdateGenreService($this->genreRepository);
        $updateGenreService($updateGenreRequest);

        $this->logger->info("Genre of id `$id` was updated.");

        return $this->respond();
    }
}

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
        $name = $this->formParam('name', '');

        $createGenreRequest = new CreateGenreRequest($name);
        $createGenreService = new CreateGenreService($this->genreRepository);
        $createGenreResponse = $createGenreService($createGenreRequest);

        $response['data']['genre'] = $createGenreResponse->genre();
        $response['headers']['Location'] = '/genre/' . $response['data']['genre']['id'];

        $this->logger->info('Genre of id `'. $response['data']['genre']['id'] .'` was createed.');

        return $this->respondWithData($response['data'], 201, $response['headers']);
    }
}

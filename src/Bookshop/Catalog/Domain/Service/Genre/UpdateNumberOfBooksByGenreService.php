<?php

namespace Bookshop\Catalog\Domain\Service\Genre;

use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Exception;

class UpdateNumberOfBooksByGenreService
{
    public function __construct(
        private readonly GenreRepository $genreRepository
    ) {
    }

    public function execute(): void
    {
        if ($this->genreRepository->updateNumberOfBooksByGenreService() === false) {
            throw new Exception('Number of books by genre could not be updated');
        }
    }
}

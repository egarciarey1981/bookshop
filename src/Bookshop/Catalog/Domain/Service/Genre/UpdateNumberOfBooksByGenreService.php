<?php

namespace Bookshop\Catalog\Domain\Service\Genre;

use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class UpdateNumberOfBooksByGenreService
{
    public function __construct(
        private readonly GenreRepository $genreRepository
    ) {
    }

    public function execute(): void
    {
        $this->genreRepository->updateNumberOfBooksByGenreService();
    }
}

<?php

namespace Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

abstract class GenreService
{
    public function __construct(
        protected readonly GenreRepository $genreRepository
    ) {
    }
}

<?php

namespace Bookshop\Catalog\Domain\BookGenre;

use Bookshop\Catalog\Domain\Book\BookId;

interface BookGenreRepository
{
    public function ofBookId(BookId $id): array;
}

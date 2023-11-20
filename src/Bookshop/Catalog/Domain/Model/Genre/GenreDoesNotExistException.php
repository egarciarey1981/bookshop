<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Shared\Domain\Exception\DomainRecordNotFoundException;

class GenreDoesNotExistException extends DomainRecordNotFoundException
{
    public function __construct(GenreId $genreId)
    {
        parent::__construct(sprintf('The genre `%s` does not exist', $genreId->value()));
    }
}

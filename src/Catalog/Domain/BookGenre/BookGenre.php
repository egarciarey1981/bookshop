<?php

namespace Bookshop\Catalog\Domain\BookGenre;

use Bookshop\Catalog\Domain\Book\BookId;
use Bookshop\Catalog\Domain\Genre\GenreId;

class BookGenre
{
	private BookId $bookId;
	private GenreId $genreId;

	public function __construct(BookId $bookId, GenreId $genreId)
	{
		$this->bookId = $bookId;
		$this->genreId = $genreId;
	}

	public function bookId(): BookId
	{
		return $this->bookId;
	}

	public function genreId(): GenreId
	{
		return $this->genreId;
	}
}
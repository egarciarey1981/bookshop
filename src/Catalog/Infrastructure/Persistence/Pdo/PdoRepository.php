<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;

class PdoRepository
{
    protected PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
}

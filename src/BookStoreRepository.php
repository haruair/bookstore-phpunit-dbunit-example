<?php

namespace BookStore;

use PDO;

class BookStoreRepository
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}

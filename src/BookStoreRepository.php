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

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM `bookstore` WHERE id = :id');
        $stmt->bindParam(':id', $id);

        $stmt->setFetchMode(PDO::FETCH_CLASS, BookStore::class); 
        $stmt->execute();

        $object = $stmt->fetch();
        return $object !== false ? $object : null;
    }
}

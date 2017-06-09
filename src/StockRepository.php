<?php

namespace BookStore;

use PDO;

class StockRepository
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function stockCount(Book $book, BookStore $bookStore = null)
    {
        $stmt = !is_null($bookStore) ? $this->getBookInStoreCountQuery() : $this->getBookCountQuery();

        $params = [
            ':bookId' => $book->getId(),
        ];
        if ($bookStore !== null) {
            $params[':bookstoreId'] = $bookStore->getId();
        }

        $stmt->execute($params);
        return $stmt->rowCount();
    }

    protected function getBookCountQuery()
    {
        return $this->db->prepare('SELECT * FROM `stock` WHERE bookId = :bookId');
    }

    protected function getBookInStoreCountQuery()
    {
        return $this->db->prepare('SELECT * FROM `stock` WHERE bookId = :bookId AND bookstoreId = :bookstoreId');
    }
}

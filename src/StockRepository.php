<?php

namespace BookStore;

use PDO;
use InvalidArgumentException;

class StockRepository
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function stockCount(Book $book, BookStore $bookStore = null)
    {
        if ($book->getId() === null) {
            throw new InvalidArgumentException("Invalid Book");
        }

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

    public function newStockTo(Book $book, BookStore $bookStore)
    {
        if ($book->getId() === null) {
            throw new InvalidArgumentException("Invalid Book");
        }

        if ($bookStore->getId() === null) {
            throw new InvalidArgumentException("Invalid BookStore");
        }

        $stmt = $this->db->prepare('INSERT INTO `stock`
          SET
            bookId = :bookId,
            bookstoreId = :bookstoreId
        ');

        $params = [
            ':bookId' => $book->getId(),
            ':bookstoreId' => $bookStore->getId(),
        ];

        $stmt->execute($params);
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

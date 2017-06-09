<?php

namespace BookStore;

use BookStore\Util\InternalPropertyAssignTrait;

use PDO;

class BookStoreRepository
{
    use InternalPropertyAssignTrait;

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

    public function findAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM `bookstore`');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, BookStore::class);
    }
    
    protected function convertToParams(BookStore $bookstore)
    {
        $params = [
            ':name' => $bookstore->getName(),
            ':address' => $bookstore->getAddress(),
            ':openedAt' => $bookstore->getOpenedAt(),
        ];

        if ($bookstore->getId() !== null) {
          $params[':id'] = $bookstore->getId();
        }

        return $params;
    }

    public function save(BookStore $bookstore)
    {
        $stmt = $this->db->prepare('INSERT INTO `bookstore`
          SET
            name = :name,
            address = :address,
            openedAt = :openedAt
        ');
        
        $params = $this->convertToParams($bookstore);
        $stmt->execute($params);

        $id = $this->db->lastInsertId();
        $this->assignInternalProperty($bookstore, 'id', $id);
    }
}

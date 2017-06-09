<?php

namespace BookStore;

use BookStore\Book;
use BookStore\Util\InternalPropertyAssignTrait;

use InvalidArgumentException;
use PDO;

class BookRepository
{
    use InternalPropertyAssignTrait;

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM `book` WHERE id = :id');
        $stmt->bindParam(':id', $id);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Book::class); 
        $stmt->execute();

        $object = $stmt->fetch();
        return $object !== false ? $object : null;
    }

    public function findAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM `book`');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Book::class);
    }

    protected function convertToParams(Book $book)
    {
        $params = [
            ':title' => $book->getTitle(),
            ':author' => $book->getAuthor(),
            ':publisher' => $book->getPublisher(),
            ':ISBN' => $book->getISBN(),
        ];

        if ($book->getId() !== null) {
          $params[':id'] = $book->getId();
        }

        return $params;
    }

    public function save(Book $book)
    {
        if ($book->getId() !== null) {
            return $this->update($book);
        }

        $stmt = $this->db->prepare('INSERT INTO `book`
          SET
            title = :title,
            author = :author,
            publisher = :publisher,
            ISBN = :ISBN
        ');
        
        $params = $this->convertToParams($book);
        $stmt->execute($params);

        $id = $this->db->lastInsertId();
        $this->assignInternalProperty($book, 'id', $id);
    }

    public function update(Book $book)
    {
        $stmt = $this->db->prepare('UPDATE `book`
          SET
            title = :title,
            author = :author,
            publisher = :publisher,
            ISBN = :ISBN
          WHERE
            id = :id
        ');

        $params = $this->convertToParams($book);
        $stmt->execute($params);
    }

    public function remove(Book $book)
    {
        if ($book->getId() === null) {
            throw new InvalidArgumentException('Book id does not exist.');
        }

        $stmt = $this->db->prepare('DELETE FROM `book` WHERE id = :id');

        $stmt->execute([
            ':id' => $book->getId(),
        ]);

        return $stmt->rowCount() > 0;
    }
}

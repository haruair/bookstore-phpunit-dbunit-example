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

        $stmt->execute([
            ':title' => $book->getTitle(),
            ':author' => $book->getAuthor(),
            ':publisher' => $book->getPublisher(),
            ':ISBN' => $book->getISBN(),
        ]);

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

        $stmt->execute([
            ':id' => $book->getId(),
            ':title' => $book->getTitle(),
            ':author' => $book->getAuthor(),
            ':publisher' => $book->getPublisher(),
            ':ISBN' => $book->getISBN(),
        ]);
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

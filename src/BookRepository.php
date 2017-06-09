<?php

namespace BookStore;

use BookStore\Repository;
use PDO;

class BookRepository
{
    use Repository\FindTrait;
    use Repository\FindAllTrait;
    use Repository\SaveUpdateTrait;
    use Repository\RemoveTrait;

    protected $db;

    protected $tableName = 'book';
    protected $key = 'id';
    protected $entityType = Book::class;
    protected $fields = [
      'title',
      'author',
      'publisher',
      'ISBN'
    ];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    protected function convertToParams(Book $book)
    {
        return $this->convertToParamsByFields($book, $this->fields, $this->key);
    }

    public function save(Book $book)
    {
        return $this->saveEntity($book);
    }

    public function update(Book $book)
    {
        return $this->updateEntity($book);
    }

    public function remove(Book $book)
    {
        return $this->removeEntity($book);
    }
}

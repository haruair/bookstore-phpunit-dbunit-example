<?php

namespace BookStore;

use BookStore\Util\InternalPropertyAssignTrait;

use BookStore\Repository;
use PDO;

class BookStoreRepository
{
    use Repository\FindTrait;
    use Repository\FindAllTrait;
    use Repository\SaveUpdateTrait;
    use Repository\RemoveTrait;

    protected $db;

    protected $tableName = 'bookstore';
    protected $key = 'id';
    protected $entityType = BookStore::class;
    protected $fields = [
      'name',
      'address',
      'openedAt',
    ];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    protected function convertToParams(BookStore $bookstore)
    {
        return $this->convertToParamsByFields($bookstore, $this->fields, $this->key);
    }

    public function save(BookStore $bookstore)
    {
        return $this->saveEntity($bookstore);
    }
    
    public function update(BookStore $bookstore)
    {
        return $this->updateEntity($bookstore);
    }

    public function remove(BookStore $bookstore)
    {
        return $this->removeEntity($bookstore);
    }
}

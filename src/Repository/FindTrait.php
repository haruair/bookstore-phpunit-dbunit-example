<?php

namespace BookStore\Repository;

use PDO;

trait FindTrait
{
    public function find($key)
    {
        $stmt = $this->db->prepare("SELECT *
          FROM `{$this->tableName}`
          WHERE {$this->key} = :{$this->key}
        ");

        $stmt->bindParam(":{$this->key}", $key);

        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entityType); 
        $stmt->execute();

        $object = $stmt->fetch();
        return $object !== false ? $object : null;
    }
}

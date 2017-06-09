<?php

namespace BookStore\Repository;

use PDO;

trait FindAllTrait
{
    public function findAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->tableName}`");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, $this->entityType);
    }
}

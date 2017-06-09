<?php

namespace BookStore\Repository;

use InvalidArgumentException;

trait RemoveTrait
{
    public function removeEntity($entity)
    {
        $keyMethodName = 'get' . ucfirst($this->key);
        if ($entity->$keyMethodName() === null) {
            throw new InvalidArgumentException("{$this->entityType} {$this->key} does not exist.");
        }

        $stmt = $this->db->prepare("DELETE FROM `{$this->tableName}` WHERE {$this->key} = :{$this->key}");

        $stmt->execute([
            ":{$this->key}" => $entity->$keyMethodName(),
        ]);

        return $stmt->rowCount() > 0;
    }
}

<?php

namespace BookStore\Repository;

use BookStore\Util\InternalPropertyAssignTrait;

trait SaveUpdateTrait
{
    use InternalPropertyAssignTrait;

    protected function convertToParamsByFields($entity, $fields, $key)
    {
        $params = [];
        foreach ($fields as $field) {
            $methodName = 'get' . ucfirst($field);
            $params[':' . $field] = $entity->$methodName();
        }

        $keyMethodName = 'get' . ucfirst($key);
        if ($entity->$keyMethodName() !== null) {
            $params[':' . $key] = $entity->$keyMethodName();
        }
        return $params;
    }

    protected function convertFieldsToSQL($fields)
    {
        $fields = array_map(function($field) {
          return "{$field} = :$field";
        }, $fields);
        return implode(', ', $fields);
    }

    public function saveEntity($entity)
    {
        $keyMethodName = 'get' . ucfirst($this->key);

        if ($entity->$keyMethodName() !== null) {
            return $this->update($entity);
        }
        $fields = $this->convertFieldsToSQL($this->fields);
        $stmt = $this->db->prepare("INSERT INTO `{$this->tableName}`
          SET {$fields}
        ");
        
        $params = $this->convertToParams($entity);
        $stmt->execute($params);

        $id = $this->db->lastInsertId();
        $this->assignInternalProperty($entity, $this->key, $id);
    }

    public function updateEntity($entity)
    {
        $fields = $this->convertFieldsToSQL($this->fields);
        $stmt = $this->db->prepare("UPDATE `{$this->tableName}`
          SET {$fields}
          WHERE
            {$this->key} = :{$this->key}
        ");

        $params = $this->convertToParams($entity);
        $stmt->execute($params);
    }
}

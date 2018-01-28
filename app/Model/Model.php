<?php

namespace App\Model;

use App\DB;

abstract class Model implements \ArrayAccess
{
    static protected $id_field;
    static protected $table;
    static protected $fields = [];
    static protected $timestamps = true;

    protected $container = [];

    public function __construct()
    {
        foreach (static::$fields as $field) {
            $this[$field] = null;
        }
    }

    public function save()
    {
        $pdo = DB::getPDO();

        $id_array = $this->getIdArray();

        $source_container = $this->container;
        if (static::$timestamps) {
            unset($source_container['created_at']);
            unset($source_container['updated_at']);
        }

        if (static::checkIfExists($id_array)) {
            $source_container_without_id = $source_container;

            foreach ($id_array as $field => $value) {
                unset($source_container_without_id[$field]);
            }

            if (static::$timestamps) {


                $query = 'UPDATE `'.static::$table.'` SET '.DB::pdoSetFromDict($source_container_without_id).', updated_at = NOW() WHERE '.
                     DB::pdoAndSequenceFromDict($id_array);
            } else {
                $query = 'UPDATE `'.static::$table.'` SET '.DB::pdoSetFromDict($source_container_without_id).' WHERE '.
                     DB::pdoAndSequenceFromDict($id_array);
            }

            $to_update = true;
            
        } else {
            $query = 'INSERT INTO `'.static::$table.'` SET '.DB::pdoSetFromDict($source_container);

            if (static::$timestamps) {
                $query = $query.', created_at = NOW(), updated_at = NOW()';
            }

            $to_update = false;
        }


        $stmt = $pdo->prepare($query);
        $stmt->execute($source_container);

        if (is_string(static::$id_field)) {
            if (!$to_update) {
                $id = $pdo->lastInsertId();
            } else {
                $id = $this[static::$id_field];
            }

            $model = static::find($id);

            foreach (static::$fields as $field) {
                $this[$field] = $model[$field];
            }
        }
    }

    public function delete()
    {
        $pdo = DB::getPDO();

        $id_array = $this->getIdArray();
        $query = 'DELETE FROM `'.static::$table.'` WHERE '.DB::pdoAndSequenceFromDict($id_array);

        $stmt = $pdo->prepare($query);
        $stmt->execute($id_array);
    }

    protected function getIdArray()
    {
        $id_array = [];

        if (is_array(static::$id_field)) {
            foreach (static::$id_field as $id_field) {
                $id_array[$id_field] = $this[$id_field];
            }
        } else {
            $id_array[static::$id_field] = $this[static::$id_field];
        }

        return $id_array;
    }

    public function toArray()
    {
        return $this->container;
    }

    public static function checkIfExists($id)
    {
        $pdo = DB::getPDO();

        $id_field = static::$id_field;
        if (!is_array($id_field)) {
            $id_field = [static::$id_field];
        }

        $query = 'SELECT COUNT(*) FROM `'.static::$table.'` WHERE '.DB::pdoAndSequence($id_field);

        $stmt = $pdo->prepare($query);
        $stmt->execute($id);

        return $stmt->fetchColumn();
    }

    public static function find($id)
    {
        $pdo = DB::getPDO();
        $query = 'SELECT * FROM `'.static::$table.'` WHERE ';

        $id_field = static::$id_field;
        if (is_array($id_field)) {
            $id = array_intersect_key($id, array_flip($id_field));
            if (count($id) != count($id_field)) {
                throw new \Exception('Wrong id array got');
            }
        } else {
            $id = [ $id_field => $id ];
            $id_field = [ $id_field ];
        }

        $query .= DB::pdoAndSequence($id_field);
        $stmt = $pdo->prepare($query);
        $stmt->execute($id);

        $raw_model = $stmt->fetch();
        if ($raw_model == null) {
            return null;
        }

        return static::getModelFromRawResult($raw_model);
    }

    public static function getAll()
    {
        $pdo = DB::getPDO();
        $query = 'SELECT * FROM `'.static::$table.'`';

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $raw_models = $stmt->fetchAll();
        
        $models = [];

        foreach ($raw_models as $raw_model) {
            $models[] = static::getModelFromRawResult($raw_model);
        }

        return $models;
    }

    public static function getAllAsArrays()
    {
        $models = static::getAll();

        $result = [];

        foreach ($models as $model) {
            $result[] = $model->toArray();
        }

        return $result;
    }

    public static function getModelFromRawResult($raw_model)
    {
        $model = new static();

        foreach (static::$fields as $key) {
            $model[$key] = $raw_model[$key];
        }

        return $model;
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}
<?php

namespace App\Model;

use App\Core\Db;
use App\Utilities\Helper;


class Model
{

    public static function find($data, $table)
    {
        $db = new Db();
        $connect = $db->connect();
        array_walk($data, function ($value) {
            Helper::sanitize($value);
        });

        $col = "";


        foreach ($data as $key => $val) {
            $col = $key;
        }

        $sql = "SELECT * FROM `{$table}` WHERE $col = :$col LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetch();
        if ($result) {
            return $result;
        }
        return (object)[];
    }

    public static function create($data, $table)
    {
        // generate template string for sql

        $columns = "";
        $values = "";

        foreach ($data as $column => $value) {
            $columns .= "`$column`, ";
            $values .= ":$column, ";
        }


        $columns = substr($columns, 0, strlen($columns) - 2);
        $values = substr($values, 0, strlen($values) - 2);

        $sql = "INSERT INTO `$table` ($columns) VALUES ($values) LIMIT 1";
        $db = new Db();
        $connect = $db->connect();
        $stmt = $connect->prepare($sql);
        if ($stmt->execute($data)) {
            return true;
        }
        return false;
    }

    public static function update($id, $data, $table)
    {

        $db = new Db();
        $connect = $db->connect();


        array_walk($data, function ($value) {
            Helper::sanitize($value);
        });

        $logic = "";
        // extraxct sql string from data array
        foreach ($data as $column => $value) {
            $logic .= "$column = :$column, ";
        }

        $logic = substr($logic, 0, strlen($logic) - 2);

        $data['id'] = $id;
        // this will remove the not needed space and coma at the ending.
        $sql = "UPDATE `$table` SET $logic WHERE id = :id LIMIT 1 ";


        $stmt = $connect->prepare($sql);

        if ($stmt->execute($data)) {
            return true;
        }

        return false;
    }


    public static function destroy($id, $tableName)
    {
        $db = new Db();
        $connect = $db->connect();
        $sql = "DELETE FROM `$tableName` WHERE id = :id  LIMIT 1";
        $stmt = $connect->prepare($sql);
        return $stmt->execute(['id' => $id]) ? true : false;
    }

    // get data
    /**
     * @param int $id value is set to default value o null
     * @param string $tableName pass in the table name that u want to query
     */
    public static function get($tableName, $id = null)
    {
        $db = new Db();
        $connect = $db->connect();

        if ($id) {
            $sql = "SELECT * FROM $tableName WHERE id = :id LIMIT 1";
            $stmt = $connect->prepare($sql);
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch();
            return $result;
        }

        $sql = "SELECT * FROM $tableName";
        $stmt = $connect->query($sql);
        $result = $stmt->fetchALl();
        return $result;
    }
}

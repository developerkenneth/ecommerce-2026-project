<?php

namespace App\Model;

use App\Core\Db;
use App\Utilities\Helper;

class User
{
    public static function create($data)
    {
        // hash password 

        $hashPassword = Helper::hasPassword($data['password']);
        $data['password'] = $hashPassword;

        // generate template string for sql

        $columns = "";
        $values = "";

        foreach ($data as $column => $value) {
            $columns .= "`$column`, ";
            $values .= ":$column, ";
        }


        $columns = substr($columns, 0, strlen($columns) - 2);
        $values = substr($values, 0, strlen($values) - 2);

        $sql = "INSERT INTO `users` ($columns) VALUES ($values) LIMIT 1";
        $db = new Db();
        $connect = $db->connect();
        $stmt = $connect->prepare($sql);
        if ($stmt->execute($data)) {
            return true;
        }
        return false;
    }

    public static function emailExist($email)
    {
        // create an object of class db
        $db = new Db();
        $connect = $db->connect();
        $sql = "SELECT * FROM `users` WHERE `email` = ? LIMIT 1 ";
        $stmt = $connect->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->rowCount();
        return $result ? true : false;
    }

    public static function findUserByEmail($email)
    {
        $db = new Db();
        $connect = $db->connect();
        $sql = "SELECT * FROM `users` WHERE `email` = ? LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function update($id, $data)
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
        $sql = "UPDATE `users` SET $logic WHERE id = :id LIMIT 1 ";


        $stmt = $connect->prepare($sql);

        if ($stmt->execute($data)) {
            return true;
        }

        return false;
    }

    public static function findUserById($id)
    {
        $db = new Db();
        $connect = $db->connect();
        $sql = "SELECT * FROM `users` WHERE `id` = ? LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result;
    }


    /**
     * @param array $data please data should have a single array element
     * @return array the actual data from the database.
     */
    public static function find($data)
    {
        $db = new Db();
        $connect = $db->connect();
        array_walk($data, function ($value) {
            Helper::sanitize($value);
        });

        $col = "";
        $value = "";

        foreach ($data as $key => $val) {
            $col = $key;
        }

        $sql = "SELECT * FROM `users` WHERE $col = :$col LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetch();
        if ($result) {
            return $result;
        }
        return (object)[];
    }

    /**
     *@param string $user_id   should be a type of string (uuid)
     *@return boolean
     */

    public static function destroy($user_id)
    {
        $db = new Db();
        $connect = $db->connect();
        $sql = "DELETE FROM `users` WHERE id = :id  LIMIT 1";
        $stmt = $connect->prepare($sql);
        return $stmt->execute(['id' => $user_id]) ? true : false;
    }
}

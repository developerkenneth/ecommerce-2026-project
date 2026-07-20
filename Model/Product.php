<?php

namespace App\Model;

use App\Core\Db;
use App\Utilities\Helper;

class Product
{

    public static function getAll($filters)
    {
        $whereClause = [];
        $whereString = "";
        if (!empty($filters)) {
            // search
            if (isset($filters['search'])) {
                $whereClause[] = "%" . $filters['search'] . "%";
                $whereString .= "`name` LIKE ?";
            }

            // max_price
            if (isset($filters['max_price']) && isset($filters['search'])) {

                $whereClause[] = $filters['max_price'];
                $whereString .= " AND `price` <= ?";
            }

            // max_price
            if (isset($filters['max_price']) && !isset($filters['search'])) {

                $whereClause[] = $filters['max_price'];
                $whereString .= "`price` <= ?";
            }

            // min_price
            if (isset($filters['min_price'])) {
                $whereClause[] = $filters['min_price'];
                $whereString .= " AND `price` >= ?";
            }
        }


        $sql = "";

        if (!empty($whereString)) {
            $sql =  "SELECT * FROM `products` WHERE $whereString  ORDER BY `id` DESC";
        } else {

            $sql = "SELECT * FROM `products`  ORDER BY `id` DESC";
        }


        // implement search functionatity
        $db = new Db();
        $connect = $db->connect();
        $stmt = $connect->prepare($sql);
        $stmt->execute($whereClause);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function find($uuid)
    {
        $db = new Db();
        $connect = $db->connect();
        $sql = "SELECT * FROM `products` WHERE `uuid` = ? LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->execute([$uuid]);
        $result = $stmt->fetch();

        if ($result) {
            return $result;
        }
        return [];
    }


    public static function create($data)
    {
        $db = new Db();
        $connect = $db->connect();


        // uuid field

        $data['uuid'] = \Ramsey\uuid\v7();

        array_walk($data, function ($value) {
            Helper::sanitize($value);
        });

        // prepare template
        $template_string = implode(', :', array_keys($data));
        $template_string = ":$template_string";

        $fields_template = implode(', ', array_keys($data));

        $sql = "INSERT INTO `products` ($fields_template) VALUES ($template_string)";
        $stmt = $connect->prepare($sql);
        if ($stmt->execute($data)) {
            return true;
        }
        return false;


        // $stmt = $connect->prepare($sql);
    }

    // update product

    public static function update($uuid, $data)
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

        $data['uuid'] = $uuid;
        // this will remove the not needed space and coma at the ending.
        $sql = "UPDATE `products` SET $logic WHERE uuid = :uuid LIMIT 1 ";

        // echo  json_encode($sql);
        // exit;

        $stmt = $connect->prepare($sql);

        if ($stmt->execute($data)) {
            return true;
        }

        return false;
    }


    public static function delete($uuid)
    {
        $db = new Db();
        $connect = $db->connect();
        $sql = "DELETE FROM `products` WHERE uuid = :uuid";
        $stmt = $connect->prepare($sql);
        if ($stmt->execute(['uuid' => $uuid])) {
            return true;
        }
        return false;
    }
}

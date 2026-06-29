<?php

namespace App\Model;

use App\Core\Db;

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
}

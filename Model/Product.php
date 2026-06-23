<?php

namespace App\Model;

use App\Core\Db;

class Product
{

    public static function getAll()
    {
        $db = new Db();
        $connect = $db->connect();
        $sql = "SELECT * FROM `products` ORDER BY `id` DESC";
        $stmt = $connect->query($sql);
        $result = $stmt->fetchAll();
        return $result;
    }
}

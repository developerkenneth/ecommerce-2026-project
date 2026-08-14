<?php

namespace App\Model;

use App\Core\Db;

class Cart
{
    public static function findItem($userId, $productUuid)
    {
        $db = new Db();
        $connect = $db->connect();

        $sql = "
            SELECT *
            FROM cart_items
            WHERE user_id = :user_id
            AND product_uuid = :product_uuid
            LIMIT 1
        ";

        $stmt = $connect->prepare($sql);

        $stmt->execute([
            'user_id' => $userId,
            'product_uuid' => $productUuid
        ]);

        $result = $stmt->fetch();

        if (!$result) {
            return [];
        }

        return (array) $result;
    }


    public static function add($userId, $productUuid, $quantity)
    {
        $existing = self::findItem(
            $userId,
            $productUuid
        );

        $db = new Db();
        $connect = $db->connect();


        if (!empty($existing)) {

            $newQuantity =
                (int) $existing['quantity'] + $quantity;

            $sql = "
                UPDATE cart_items
                SET quantity = :quantity,
                    updated_at = NOW()
                WHERE id = :id
                LIMIT 1
            ";

            $stmt = $connect->prepare($sql);

            return $stmt->execute([
                'quantity' => $newQuantity,
                'id' => $existing['id']
            ]);
        }


        $sql = "
            INSERT INTO cart_items
            (
                user_id,
                product_uuid,
                quantity,
                created_at,
                updated_at
            )
            VALUES
            (
                :user_id,
                :product_uuid,
                :quantity,
                NOW(),
                NOW()
            )
        ";

        $stmt = $connect->prepare($sql);

        return $stmt->execute([
            'user_id' => $userId,
            'product_uuid' => $productUuid,
            'quantity' => $quantity
        ]);
    }


    public static function getUserCart($userId)
    {
        $db = new Db();
        $connect = $db->connect();

        $sql = "
            SELECT
                cart_items.id,
                cart_items.product_uuid,
                cart_items.quantity,

                products.name,
                products.price,
                products.discount_percentage,
                products.photos,
                products.stocks_available,
                products.brand,
                products.category

            FROM cart_items

            INNER JOIN products
                ON products.uuid = cart_items.product_uuid

            WHERE cart_items.user_id = :user_id

            ORDER BY cart_items.created_at DESC
        ";

        $stmt = $connect->prepare($sql);

        $stmt->execute([
            'user_id' => $userId
        ]);

        $results = $stmt->fetchAll();

        return array_map(
            function ($item) {
                return (array) $item;
            },
            $results
        );
    }


    public static function updateQuantity(
        $userId,
        $productUuid,
        $quantity
    ) {
        $db = new Db();
        $connect = $db->connect();

        $sql = "
            UPDATE cart_items
            SET quantity = :quantity,
                updated_at = NOW()
            WHERE user_id = :user_id
            AND product_uuid = :product_uuid
            LIMIT 1
        ";

        $stmt = $connect->prepare($sql);

        return $stmt->execute([
            'quantity' => $quantity,
            'user_id' => $userId,
            'product_uuid' => $productUuid
        ]);
    }


    public static function remove(
        $userId,
        $productUuid
    ) {
        $db = new Db();
        $connect = $db->connect();

        $sql = "
            DELETE FROM cart_items
            WHERE user_id = :user_id
            AND product_uuid = :product_uuid
            LIMIT 1
        ";

        $stmt = $connect->prepare($sql);

        return $stmt->execute([
            'user_id' => $userId,
            'product_uuid' => $productUuid
        ]);
    }


    public static function clear($userId)
    {
        $db = new Db();
        $connect = $db->connect();

        $sql = "
            DELETE FROM cart_items
            WHERE user_id = :user_id
        ";

        $stmt = $connect->prepare($sql);

        return $stmt->execute([
            'user_id' => $userId
        ]);
    }
}

<?php

namespace App\Core;

require_once __DIR__ . "../../init.php";

use PDO;

class Db
{

    private $pdo;

    public function __construct()
    {

        $host = $_ENV['DB_HOST'];
        $databaseName = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];

        try {

            $dsn = "mysql:host=$host;dbname=$databaseName;";
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        } catch (\PDOException $error) {
            $errorMessage = $error->getMessage();
            die("connection failed : $errorMessage");
        }
    }

    public function connect()
    {
        return $this->pdo;
    }
}
